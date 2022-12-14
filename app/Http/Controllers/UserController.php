<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function edit($userUuid)
    {
        $user = User::where('uuid', $userUuid)->firstOrFail();

        return Inertia::render('Users/Edit', [
            'user' => [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function update(Request $request, $userUuid)
    {
        $user = User::where('uuid', $userUuid)->firstOrFail();

        $validaData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($request->email !== $user->email) {
            $validaData['email_verified_at'] = null;
        }

        $user->update($validaData);

        return redirect()->route('users.edit', ['userUuid' => $user->uuid]);
    }
}
