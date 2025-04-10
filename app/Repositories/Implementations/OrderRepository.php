<?php
namespace App\Repositories\Implementations;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Str;

class OrderRepository implements OrderRepositoryInterface
{
    public function placeOrder(int $userId, string $shippingAddress)
    {
        $cart = Cart::with('items')->where('user_id', $userId)->first();

        if (! $cart || $cart->items->isEmpty()) {
            throw new \Exception('Cart is empty.');
        }

        $total = 0;

        
        foreach ($cart->items as $item) {
            $product = Product::findOrFail($item->product_id);

            if ($product->stock < $item->quantity) {
                throw new \Exception("Insufficient stock for {$product->name}");
            }

            $total += $product->price * $item->quantity;
        }

        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $shippingAddress
        ]);

        // Add order items and update stock
        foreach ($cart->items as $item) {
            $product = Product::findOrFail($item->product_id);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $product->price
            ]);

            $product->decrement('stock', $item->quantity);
        }

        // Clear the user's cart items
        $cart->items()->delete();

        return $order->load('items.product');
    }
}
