<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProductService {
    public function __construct(public ProductRepositoryInterface $productRepo) {}

    public function getAll() {
        return $this->productRepo->getAll();
    }

    public function getById($id) {
        return $this->productRepo->findById($id);
    }

    public function getFiltered(array $filters)
    {
        return $this->productRepo->getFiltered($filters);
    }
}