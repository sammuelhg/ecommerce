<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Sync cart from client-side localStorage to server-side session.
     * This is called when the user clicks "Finalize Purchase".
     */
    /**
     * Sync cart from client-side localStorage to server-side session.
     * This is called when the user clicks "Finalize Purchase".
     */
    public function sync(Request $request, CartService $cartService)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
        ]);

        // Clear existing cart
        $cartService->clear();

        // Add all items from client cart to server cart
        foreach ($request->cart as $item) {
            $product = Product::find($item['id']);
            
            if ($product && $product->stock >= $item['qty']) {
                $cartService->add($product, $item['qty']);
            }
        }

        // Return success and redirect URL
        return response()->json([
            'success' => true,
            'redirect_url' => route('checkout.index'),
            'message' => 'Carrinho sincronizado com sucesso!'
        ]);
    }

    /**
     * Display the checkout page.
     */
    public function checkout(CartService $cartService)
    {
        $cartItems = $cartService->get();
        $total = $cartService->total();
        return view('shop.checkout', compact('cartItems', 'total'));
    }
}
