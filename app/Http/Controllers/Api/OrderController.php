<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;

class OrderController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private OrderService $orderService) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:500'
        ]);

        try {
            $order = $this->orderService->checkout(auth()->id(), $data['shipping_address']);
            $order_data = new OrderResource($order);
            return $this->responseSuccess($order_data, 'Order placed successfully');
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}
