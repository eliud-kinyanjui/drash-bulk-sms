<?php

namespace App\Http\Controllers;

use App\Models\ContactGroup;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContactGroupController extends Controller
{
    use Utilities;

    public function index()
    {
        $contactGroups = Auth::user()->contactGroups()->latest()->get();

        return Inertia::render('ContactGroups/Index', [
            'contactGroups' => $contactGroups,
        ]);
    }

    public function create()
    {
        return Inertia::render('ContactGroups/Create');
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validData['uuid'] = $this->generateUuid();
        $validData['user_id'] = Auth::user()->id;

        ContactGroup::create($validData);

        flash()->addSuccess('Contact group created successfully.');

        return redirect()->route('contactGroups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactGroup  $contactGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ContactGroup $contactGroup)
    {
        //
    }

    public function edit($contactGroupUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        return Inertia::render('ContactGroups/Edit', [
            'contactGroup' => $contactGroup,
        ]);
    }

    public function update(Request $request, $contactGroupUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        $validData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $contactGroup->update($validData);

        flash()->addSuccess('Contact group updated successfully.');

        return redirect()->route('contactGroups.index');
    }

    public function delete($contactGroupUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        return Inertia::render('ContactGroups/Delete', [
            'contactGroup' => $contactGroup,
        ]);
    }

    public function destroy($contactGroupUuid)
    {
        $contactGroup = Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();

        $contactGroup->delete();

        flash()->addSuccess('Contact group deleted successfully.');

        return redirect()->route('contactGroups.index');
    }
}
