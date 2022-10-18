<?php

namespace App\Http\Controllers;

use App\Traits\Utilities;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    use Utilities;

    public function create($contactGroupUuid)
    {
        $contactGroup = $this->getContactGroup($contactGroupUuid);

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

        $validData['uuid'] = $this->generateUuid();

        $contactGroup = $this->getContactGroup($contactGroupUuid);

        $contactGroup->contacts()->create($validData);

        return redirect()->route('contactGroups.show', ['contactGroupUuid' => $contactGroup->uuid]);
    }

    public function edit($contactGroupUuid, $contactUuid)
    {
        $contactGroup = $this->getContactGroup($contactGroupUuid);
        $contact = $this->getContact($contactGroup, $contactUuid);

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

        $contactGroup = $this->getContactGroup($contactGroupUuid);
        $contact = $this->getContact($contactGroup, $contactUuid);

        $contact->update($validData);

        return redirect()->route('contactGroups.show', ['contactGroupUuid' => $contactGroup->uuid]);
    }

    public function delete($contactGroupUuid, $contactUuid)
    {
        $contactGroup = $this->getContactGroup($contactGroupUuid);
        $contact = $this->getContact($contactGroup, $contactUuid);

        return Inertia::render('Contacts/Delete', [
            'contactGroup' => $contactGroup,
            'contact' => $contact,
        ]);
    }

    public function destroy($contactGroupUuid, $contactUuid)
    {
        $contactGroup = $this->getContactGroup($contactGroupUuid);
        $contact = $this->getContact($contactGroup, $contactUuid);

        $contact->delete();

        return redirect()->route('contactGroups.show', ['contactGroupUuid' => $contactGroup->uuid]);
    }

    private function getContact($contactGroup, $contactUuid)
    {
        return $contactGroup->contacts()->where('uuid', $contactUuid)->firstOrFail();
    }
}
