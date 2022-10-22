<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $firstNameArray = explode(' ', Auth::user()->name);

        return array_merge(parent::share($request), [
            'auth' => [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'canResetPassword' => Route::has('password.request'),
                'user' => Auth::user() ? [
                    'uuid' => Auth::user()->uuid,
                    'name' => Auth::user()->name,
                    'firstName' => $firstNameArray[0],
                ] : null,
            ],
            'env' => [
                'APP_NAME' => config('app.name'),
            ],
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
                'resent' => fn () => $request->session()->get('resent'),
            ],
        ]);
    }
}
