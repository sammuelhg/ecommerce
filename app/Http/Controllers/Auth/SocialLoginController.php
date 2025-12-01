<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erro ao conectar com ' . ucfirst($provider));
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update existing user with social ID if not present
            if ($provider === 'google' && !$user->google_id) {
                $user->update(['google_id' => $socialUser->getId()]);
            } elseif ($provider === 'facebook' && !$user->facebook_id) {
                $user->update(['facebook_id' => $socialUser->getId()]);
            }
            
            // Update avatar if missing
            if (!$user->avatar) {
                $user->update(['avatar' => $socialUser->getAvatar()]);
            }

            Auth::login($user);
        } else {
            // Create new user
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => null, // Social login users don't have a password initially
                $provider . '_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'email_verified_at' => now(), // Assume social email is verified
            ]);

            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user, 'login com ' . ucfirst($provider)));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro ao enviar email de boas-vindas social: ' . $e->getMessage());
            }

            Auth::login($user);
        }

        // Merge session cart and wishlist to database
        app(\App\Services\CartService::class)->mergeSessionToDatabase();
        app(\App\Services\WishlistService::class)->mergeSessionToDatabase();

        return redirect()->route('shop.index')->with('success', 'Login realizado com sucesso!');
    }
}
