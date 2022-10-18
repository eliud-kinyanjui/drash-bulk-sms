<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MessageController extends Controller
{
    use Utilities;

    public function index()
    {
        $messages = Auth::user()->messages()
            ->with(['contactGroup' => function ($query) {
                $query->withTrashed();
            }])
            ->latest()
            ->get();

        return Inertia::render('Messages/Index', [
            'messages' => $messages,
        ]);
    }

    public function create()
    {
        $contactGroups = $this->getContactGroups();

        return Inertia::render('Messages/Create', [
            'contactGroups' => $contactGroups,
        ]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'contact_group' => 'required',
            'message' => 'required|string|max:255',
        ]);

        $contactGroup = Auth::user()->contactGroups()->findOrFail($validData['contact_group']);
        $contacts = [];

        foreach ($contactGroup->contacts as $contact) {
            $contacts[] = substr_replace($contact->phone, '+254', 0, 1);
        }

        $AT = new AfricasTalking(config('africastalking.username'), config('africastalking.apiKey'));
        $sms = $AT->sms();

        $result = $sms->send([
            'to' => $contacts,
            'message' => $validData['message'],
        ]);

        $messageData = $result['data']->SMSMessageData;

        DB::transaction(function () use ($contactGroup, $validData, $messageData) {
            $message = Auth::user()->messages()->create([
                'uuid' => $this->generateUuid(),
                'contact_group_id' => $contactGroup->id,
                'message' => $validData['message'],
                'at_response' => $messageData->Message,
            ]);

            $messageDetails = collect($messageData->Recipients)->map(function ($recipient) use ($message) {
                return [
                    'message_id' => $message->id,
                    'at_status_code' => $recipient->statusCode,
                    'at_number' => $recipient->number,
                    'at_cost' => $recipient->cost,
                    'at_status' => $recipient->status,
                    'at_message_id' => $recipient->messageId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            $message->messageDetails()->insert($messageDetails->toArray());
        });

        return redirect()->route('messages.index');
    }

    public function show($messageUuid)
    {
        $message = Auth::user()
            ->messages()
            ->where('uuid', $messageUuid)
            ->with(['contactGroup' => function ($query) {
                $query->withTrashed();
            }])
            ->with('messageDetails')
            ->firstOrFail();

        return Inertia::render('Messages/Show', [
            'message' => $message,
        ]);
    }
}
