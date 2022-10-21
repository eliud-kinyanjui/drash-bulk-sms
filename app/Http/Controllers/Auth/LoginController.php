<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use App\Providers\RouteServiceProvider;
use App\Traits\Utilities;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers, Utilities;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected $providers = [
        'google', 'facebook', 'twitter', 'github',
    ];

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function redirectToProvider($driver)
    {
        if (! $this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            $redirectUrl = Socialite::driver($driver)->redirect()->getTargetUrl();

            return Inertia::location($redirectUrl);
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        return empty($user->email)
            ? $this->sendFailedResponse("No email ID returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    private function loginOrCreateAccount($providerUser, $driver)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if ($user) {
            $user->update([
                'avatar' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token,
            ]);
        } else {
            $user = User::create([
                'uuid' => $this->generateUuid(),
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(15)),
                'avatar' => $providerUser->getAvatar(),
                'provider' => $driver,
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
            ]);

            Notification::route('slack', config('slack.newUserRegisteredWebhook'))
                ->notify(new NewUserRegistered($user));
        }

        Auth::login($user);

        return $this->sendSuccessResponse();
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    private function sendSuccessResponse()
    {
        return redirect()->intended('home');
    }

    private function sendFailedResponse($message = null)
    {
        return redirect()->route('login')->with('status', [
            'type' => 'alert-danger',
            'message' => $message ?: 'Unable to login, try with another provider to login.',
        ]);
    }
}
