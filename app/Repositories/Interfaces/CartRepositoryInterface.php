<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface 
{
    public function addToCart($userId , array $data);
    public function removeFromCart($userId , $itemId);
}

?>