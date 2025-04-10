<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    public function __construct(private OrderRepositoryInterface $orderRepo) {}

    public function checkout(int $userId, string $shippingAddress)
    {
        return $this->orderRepo->placeOrder($userId, $shippingAddress);
    }
}