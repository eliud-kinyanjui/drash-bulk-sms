<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getContactGroups()
    {
        return Auth::user()->contactGroups()->orderBy('name', 'asc')->get();
    }

    protected function getContactGroup($contactGroupUuid)
    {
        return Auth::user()->contactGroups()->where('uuid', $contactGroupUuid)->firstOrFail();
    }
}
