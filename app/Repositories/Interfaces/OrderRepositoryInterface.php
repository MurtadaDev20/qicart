<?php

namespace App\Repositories\Interfaces;

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function placeOrder(int $userId, string $shippingAddress);
}