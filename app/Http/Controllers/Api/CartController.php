<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\Cart;
use App\Traits\ApiResponseTrait;

class CartController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private CartService $cartService) {}

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cartItem = $this->cartService->addItem(auth()->id(), $data);
            $data = new CartResource($cartItem);

            return $this->responseSuccess($data, 'Item added to cart successfully');
        } catch (\Exception $e) {
            return $this->responseError([], $e->getMessage(),);
        }
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        $removed = $this->cartService->removeItem(auth()->id(), $id);
        
        if ($removed) {
            return $this->responseSuccess([], 'Item removed from cart successfully');
        }

        return $this->responseError([], 'Item not found in cart', 404);
    }

    /**
     * View cart items and total
     */
    // public function show()
    // {
    //     $cart = Cart::with('items.product')
    //         ->where('user_id', auth()->id())
    //         ->first();

    //     if (!$cart) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Cart is empty',
    //             'data' => []
    //         ]);
    //     }

    //     $total = $cart->items->sum(function ($item) {
    //         return $item->quantity * $item->price;
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Cart retrieved',
    //         'data' => [
    //             'items' => $cart->items,
    //             'total' => $total
    //         ]
    //     ]);
    // }
}
