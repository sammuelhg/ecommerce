<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegistrationService;
use App\DTOs\Auth\RegisterUserDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(
        protected RegistrationService $service
    ) {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     * 
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(): View
    {
        // Mantendo a lógica de carregar produtos para a vitrine da view de registro
        $products = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $productsJson = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'imageText' => $product->image ?? 'Produto',
                'isOffer' => (bool) $product->is_offer,
                'oldPrice' => $product->old_price ? (float) $product->old_price : null,
                'stock' => $product->stock,
                'category' => $product->category?->name ?? 'Geral'
            ];
        })->toJson();

        return view('auth.register', compact('products', 'productsJson'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        // 1. Transforma Request validado em DTO
        $dto = RegisterUserDTO::fromArray($request->validated());

        // 2. Chama o Service
        $user = $this->service->registerUser($dto);

        // 3. Lógica HTTP (Login e Redirect)
        Auth::login($user);

        return redirect()->route('shop.index')->with('success', 'Cadastro realizado com sucesso!');
    }
}
