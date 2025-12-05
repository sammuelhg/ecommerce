<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
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

        return view('auth.login', compact('products', 'productsJson'));
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (auth()->user()->is_admin) {
            return '/admin';
        }
        return '/loja';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        app(\App\Services\CartService::class)->mergeSessionToDatabase();
        app(\App\Services\WishlistService::class)->mergeSessionToDatabase();
        
        session()->flash('success', 'Bem-vindo de volta, ' . $user->name . '!');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
