<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Cart\CartItemDTO;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService extends BaseService
{
    const SESSION_KEY = 'shop_cart';

    public function get(): array
    {
        if (Auth::check()) {
            $items = CartItem::where('user_id', Auth::id())->with('product')->get();
            $cart = [];
            foreach ($items as $item) {
                if ($item->product) {
                    $cart[$item->product_id] = [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => (float) $item->product->price,
                        'image' => $item->product->image,
                        'qty' => $item->qty,
                        'slug' => $item->product->slug,
                        'subtotal' => (float) $item->product->price * $item->qty
                    ];
                }
            }
            return $cart;
        }

        return Session::get(self::SESSION_KEY, []);
    }

    public function add(CartItemDTO $dto): void
    {
        $product = Product::find($dto->productId);
        
        if (!$product) {
            return;
        }

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $dto->productId)
                ->first();

            if ($cartItem) {
                $cartItem->qty += $dto->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $dto->productId,
                    'qty' => $dto->quantity
                ]);
            }
        } else {
            $cart = $this->get();
            
            if (isset($cart[$dto->productId])) {
                $cart[$dto->productId]['qty'] += $dto->quantity;
                $cart[$dto->productId]['subtotal'] = $cart[$dto->productId]['price'] * $cart[$dto->productId]['qty'];
            } else {
                $cart[$dto->productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'image' => $product->image,
                    'qty' => $dto->quantity,
                    'slug' => $product->slug,
                    'subtotal' => (float) $product->price * $dto->quantity
                ];
            }

            Session::put(self::SESSION_KEY, $cart);
        }
    }

    public function remove(int $productId): void
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

    public function update(int $productId, int $qty): void
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
                $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $qty;
                Session::put(self::SESSION_KEY, $cart);
            }
        }
    }

    public function clear(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            Session::forget(self::SESSION_KEY);
        }
    }

    /**
     * @param CartItemDTO[] $items
     */
    public function sync(array $items): void
    {
        $this->clear();

        foreach ($items as $item) {
            if ($item instanceof CartItemDTO) {
                $this->add($item);
            }
        }
    }

    public function total(): float
    {
        return array_reduce($this->get(), function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0.0);
    }

    public function count(): int
    {
        return array_reduce($this->get(), function ($carry, $item) {
            return $carry + $item['qty'];
        }, 0);
    }

    public function mergeSessionToDatabase(): void
    {
        if (!Auth::check()) return;

        $sessionCart = Session::get(self::SESSION_KEY, []);

        foreach ($sessionCart as $item) {
             // Create DTO from session data to use the standard add method
             $dto = new CartItemDTO(
                 productId: (int) $item['id'],
                 quantity: (int) $item['qty']
             );
             $this->add($dto);
        }

        Session::forget(self::SESSION_KEY);
    }
}
