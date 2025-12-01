<?php

namespace App\Services;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistService
{
    const SESSION_KEY = 'shop_wishlist';

    public function get()
    {
        if (Auth::check()) {
            $items = WishlistItem::where('user_id', Auth::id())->with('product')->get();
            $wishlist = [];
            foreach ($items as $item) {
                if ($item->product) {
                    $wishlist[$item->product_id] = [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'image' => $item->product->image,
                        'slug' => $item->product->slug
                    ];
                }
            }
            return $wishlist;
        }

        return Session::get(self::SESSION_KEY, []);
    }

    public function add(Product $product)
    {
        if (Auth::check()) {
            WishlistItem::firstOrCreate([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
        } else {
            $wishlist = $this->get();

            if (!isset($wishlist[$product->id])) {
                $wishlist[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'slug' => $product->slug
                ];
                Session::put(self::SESSION_KEY, $wishlist);
            }
        }
    }

    public function remove($productId)
    {
        if (Auth::check()) {
            WishlistItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $wishlist = $this->get();
            
            if (isset($wishlist[$productId])) {
                unset($wishlist[$productId]);
                Session::put(self::SESSION_KEY, $wishlist);
            }
        }
    }

    public function toggle(Product $product)
    {
        if (Auth::check()) {
            $item = WishlistItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($item) {
                $item->delete();
                return false; // Removed
            } else {
                WishlistItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id
                ]);
                return true; // Added
            }
        } else {
            $wishlist = $this->get();

            if (isset($wishlist[$product->id])) {
                $this->remove($product->id);
                return false; // Removed
            } else {
                $this->add($product);
                return true; // Added
            }
        }
    }

    public function has($productId)
    {
        if (Auth::check()) {
            return WishlistItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        }

        $wishlist = $this->get();
        return isset($wishlist[$productId]);
    }

    public function count()
    {
        if (Auth::check()) {
            return WishlistItem::where('user_id', Auth::id())->count();
        }

        return count($this->get());
    }

    public function clear()
    {
        if (Auth::check()) {
            WishlistItem::where('user_id', Auth::id())->delete();
        } else {
            Session::forget(self::SESSION_KEY);
        }
    }

    public function mergeSessionToDatabase()
    {
        if (!Auth::check()) return;

        $sessionWishlist = Session::get(self::SESSION_KEY, []);

        foreach ($sessionWishlist as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $this->add($product);
            }
        }

        Session::forget(self::SESSION_KEY);
    }
}
