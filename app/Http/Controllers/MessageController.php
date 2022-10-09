<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create($contactGroupUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        if (! $contactGroup->total_contacts) {
            return redirect()->route('contactGroups.contacts.create', ['contactGroupUuid' => $contactGroup->uuid]);
        }

        return Inertia::render('Messages/Create', [
            'contactGroup' => $contactGroup,
        ]);
    }

    public function store(Request $request, $contactGroupUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        if (! $contactGroup->total_contacts) {
            return redirect()->route('contactGroups.contacts.create', ['contactGroupUuid' => $contactGroup->uuid]);
        }

        $validData = $request->validate([
            'message' => 'required|string|max:255',
        ]);

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

        dd($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
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
