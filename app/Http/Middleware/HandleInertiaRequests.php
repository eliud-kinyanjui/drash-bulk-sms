<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

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
        if ($request->user()) {
            $firstNameArray = explode(' ', $request->user()->name);
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'canResetPassword' => Route::has('password.request'),
                'user' => $request->user() ? [
                    'uuid' => $request->user()->uuid,
                    'name' => $request->user()->name,
                    'firstName' => $firstNameArray[0],
                    'credit' => $request->user()->credit,
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
