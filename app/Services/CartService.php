<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    const SESSION_KEY = 'shop_cart';

    public function get()
    {
        if (Auth::check()) {
            $items = CartItem::where('user_id', Auth::id())->with('product')->get();
            $cart = [];
            foreach ($items as $item) {
                if ($item->product) {
                    $cart[$item->product_id] = [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'image' => $item->product->image,
                        'qty' => $item->qty,
                        'slug' => $item->product->slug
                    ];
                }
            }
            return $cart;
        }

        return Session::get(self::SESSION_KEY, []);
    }

    public function add(Product $product, $qty = 1)
    {
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->qty += $qty;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'qty' => $qty
                ]);
            }
        } else {
            $cart = $this->get();

            if (isset($cart[$product->id])) {
                $cart[$product->id]['qty'] += $qty;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'qty' => $qty,
                    'slug' => $product->slug
                ];
            }

            Session::put(self::SESSION_KEY, $cart);
        }
    }

    public function remove($productId)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = $this->get();
            
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put(self::SESSION_KEY, $cart);
            }
        }
    }

    public function update($productId, $qty)
    {
        $qty = max(1, $qty);

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->update(['qty' => $qty]);
        } else {
            $cart = $this->get();

            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] = $qty;
                Session::put(self::SESSION_KEY, $cart);
            }
        }
    }

    public function clear()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            Session::forget(self::SESSION_KEY);
        }
    }

    public function total()
    {
        return array_reduce($this->get(), function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);
    }

    public function count()
    {
        return array_reduce($this->get(), function ($carry, $item) {
            return $carry + $item['qty'];
        }, 0);
    }

    public function mergeSessionToDatabase()
    {
        if (!Auth::check()) return;

        $sessionCart = Session::get(self::SESSION_KEY, []);

        foreach ($sessionCart as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $this->add($product, $item['qty']);
            }
        }

        Session::forget(self::SESSION_KEY);
    }
}
