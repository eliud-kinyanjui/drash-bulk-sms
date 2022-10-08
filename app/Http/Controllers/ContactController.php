<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContactController extends Controller
{
    use Utilities;

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

        return Inertia::render('Contacts/Create', [
            'contactGroup' => $contactGroup,
        ]);
    }

    public function store(Request $request, $contactGroupUuid)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
        ]);

        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        $validData['uuid'] = $this->generateUuid();
        $validData['contact_group_id'] = $contactGroup->id;

        Contact::create($validData);

        return redirect()->route('contactGroups.show', ['contactGroupUuid' => $contactGroup->uuid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    public function edit($contactGroupUuid, $contactUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();
        $contact = $contactGroup->contacts()->where('uuid', $contactUuid)->firstOrFail();

        return Inertia::render('Contacts/Edit', [
            'contactGroup' => $contactGroup,
            'contact' => $contact,
        ]);
    }

    public function update(Request $request, $contactGroupUuid, $contactUuid)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
        ]);

        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();
        $contact = $contactGroup->contacts()->where('uuid', $contactUuid)->firstOrFail();

        $contact->update($validData);

        return redirect()->route('contactGroups.show', ['contactGroupUuid' => $contactGroup->uuid]);
    }

    public function delete($contactGroupUuid, $contactUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();
        $contact = $contactGroup->contacts()->where('uuid', $contactUuid)->firstOrFail();

        return Inertia::render('Contacts/Delete', [
            'contactGroup' => $contactGroup,
            'contact' => $contact,
        ]);
    }

    public function destroy($contactGroupUuid, $contactUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();
        $contact = $contactGroup->contacts()->where('uuid', $contactUuid)->firstOrFail();

        $contact->delete();

        return redirect()->route('contactGroups.show', ['contactGroupUuid' => $contactGroup->uuid]);
    }
}
