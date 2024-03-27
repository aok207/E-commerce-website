<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $existingUser = User::where('email', $socialUser->getEmail())->first();

            if ($existingUser) {
                if ($existingUser->provider === $provider) {
                    Auth::login($existingUser);

                    return redirect('/')->with('success', "Welcome $existingUser->name");
                }

                return redirect('/login')->with('error', 'The same email is already used in other methods to log in.');
            }

            $user = User::create([
                'name' => $socialUser->getNickname() ? $socialUser->getNickname() : $socialUser->getName(),
                'email' => $socialUser->email,
                'provider_token' => $socialUser->token,
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'email_verified_at' => now()
            ]);

            Auth::login($user);

            return redirect('/')->with('success', "Welcome $user->name");
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong.');
        }
    }
}
