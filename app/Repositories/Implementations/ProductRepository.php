<?php

namespace App\Repositories\Implementations;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {
    public function getAll() {
        return Product::paginate(10);
    }

    public function findById($id) {
        return Product::findOrFail($id);
    }
}