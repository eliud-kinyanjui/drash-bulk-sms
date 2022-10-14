<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Message;
use App\Models\MessageDetail;
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
        $contactGroups = Auth::user()->contactGroups()->orderBy('name', 'asc')->get();

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
            $message = Message::create([
                'uuid' => $this->generateUuid(),
                'contact_group_id' => $contactGroup->id,
                'message' => $validData['message'],
                'at_response' => $messageData->Message,
                'user_id' => Auth::user()->id,
            ]);

            $messageDetails = [];

            foreach ($messageData->Recipients as $recipient) {
                $messageDetails[] = [
                    'message_id' => $message->id,
                    'at_status_code' => $recipient->statusCode,
                    'at_number' => $recipient->number,
                    'at_cost' => $recipient->cost,
                    'at_status' => $recipient->status,
                    'at_message_id' => $recipient->messageId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            MessageDetail::insert($messageDetails);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
