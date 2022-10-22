<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $contactGroups = Auth::user()->contactGroups()->count();
        $messages = Auth::user()->messages()->count();

        return Inertia::render('Home', [
            'stats' => [
                'contactGroups' => $contactGroups,
                'messages' => $messages,
            ],
        ]);
    }
}
