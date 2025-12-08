<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\SocialAuthService;
use App\DTOs\Auth\SocialUserDTO;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLoginController extends Controller
{
    public function __construct(
        protected SocialAuthService $socialAuthService,
        protected CartService $cartService,
        protected WishlistService $wishlistService
    ) {}

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
        } catch (InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Erro na autenticação social. Tente novamente.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erro ao conectar com ' . ucfirst($provider));
        }

        // Cria DTO com dados normalizados
        $dto = new SocialUserDTO(
            name: $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuário',
            email: $socialUser->getEmail(),
            providerId: $socialUser->getId(),
            providerName: $provider,
            avatar: $socialUser->getAvatar()
        );

        // Processa usuário via Service
        $user = $this->socialAuthService->handleSocialUser($dto);

        // Loga o usuário
        Auth::login($user);

        // Merge de carrinho e wishlist (mantido no controller pois lida com infra de Sessão/HTTP)
        $this->cartService->mergeSessionToDatabase();
        $this->wishlistService->mergeSessionToDatabase();

        return redirect()->route('shop.index')->with('success', 'Login realizado com sucesso!');
    }
}
