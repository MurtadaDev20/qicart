<?php

namespace App\Repositories\Implementations;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface 
{
    
    public function addToCart($userId, array $data)
    {
        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            throw new \Exception('Not enough stock');
        }

        // Get or create cart for the user
        $cart = Cart::firstOrCreate([
            'user_id' => $userId
        ]);

        // Check if item already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $data['product_id'])
            ->first();

            $totalPrice = $product->price * $data['quantity'];

        if ($cartItem) {
            $cartItem->quantity += $data['quantity'];
            $cartItem->price = $totalPrice;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'price' => $totalPrice,
            ]);
        }

        return $cartItem;
    }

    public function removeFromCart($userId, $itemId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (! $cart) {
            return false;
        }

        $deleted = CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->delete();

        return $deleted;
    }
}