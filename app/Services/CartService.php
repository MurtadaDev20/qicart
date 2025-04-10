<?php
namespace App\Services;

use App\Repositories\Interfaces\CartRepositoryInterface;

class CartService {
    public function __construct(private CartRepositoryInterface $cartRepo) {}

    public function addItem($userId, array $data) {
        return $this->cartRepo->addToCart($userId, $data);
    }

    public function removeItem($userId, $itemId) {
        return $this->cartRepo->removeFromCart($userId, $itemId);
    }
}
