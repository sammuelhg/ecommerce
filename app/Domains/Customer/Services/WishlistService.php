<?php

declare(strict_types=1);

namespace App\Domains\Customer\Services;

use App\Domains\Catalog\Models\Product;
use App\Domains\Customer\Models\WishlistItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistService
{
    const SESSION_KEY = 'shop_wishlist';

    private static ?array $loadedWishlistIds = null;

    /**
     * Get the full wishlist data.
     */
    public function get(): array
    {
        if (Auth::check()) {
            if (self::$loadedWishlistIds !== null) {
                return self::$loadedWishlistIds;
            }

            $items = WishlistItem::where('user_id', Auth::id())->with('product')->get();
            $wishlist = [];
            foreach ($items as $item) {
                if ($item->product) {
                    $wishlist[$item->product_id] = [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => (float) $item->product->price,
                        'image' => $item->product->image,
                        'slug' => $item->product->slug
                    ];
                }
            }
            self::$loadedWishlistIds = $wishlist;
            return $wishlist;
        }

        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Get only the product IDs in the wishlist.
     */
    public function getIds(): array
    {
        if (Auth::check()) {
            if (self::$loadedWishlistIds !== null) {
                return array_keys(self::$loadedWishlistIds);
            }
            
            // Optimization: Only select product_id if we only need IDs
            return WishlistItem::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }

        return array_keys($this->get());
    }

    public function add(Product $product): void
    {
        self::$loadedWishlistIds = null;
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
                    'price' => (float) $product->price,
                    'image' => $product->image,
                    'slug' => $product->slug
                ];
                Session::put(self::SESSION_KEY, $wishlist);
            }
        }
    }

    public function remove(int $productId): void
    {
        self::$loadedWishlistIds = null;
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

    public function toggle(Product $product): bool
    {
        self::$loadedWishlistIds = null;
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

    public function has(int $productId): bool
    {
        // Use in-memory cache if already loaded (e.g. from get() or previous check)
        if (self::$loadedWishlistIds !== null) {
            return isset(self::$loadedWishlistIds[$productId]);
        }

        if (Auth::check()) {
            // Hotfix/Optimization: Bulk load all IDs for the user in the first check 
            // to avoid N+1 during serialization of many products.
            $this->get(); 
            return isset(self::$loadedWishlistIds[$productId]);
        }

        $wishlist = $this->get();
        return isset($wishlist[$productId]);
    }

    public function count(): int
    {
        if (Auth::check()) {
            if (self::$loadedWishlistIds !== null) {
                return count(self::$loadedWishlistIds);
            }
            return WishlistItem::where('user_id', Auth::id())->count();
        }

        return count($this->get());
    }

    public function clear(): void
    {
        self::$loadedWishlistIds = null;
        if (Auth::check()) {
            WishlistItem::where('user_id', Auth::id())->delete();
        } else {
            Session::forget(self::SESSION_KEY);
        }
    }

    public function mergeSessionToDatabase(): void
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
        self::$loadedWishlistIds = null;
    }
}
