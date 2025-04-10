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

    public function getFiltered(array $filters) {
        $query = Product::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';

        return $query->orderBy($sort, $direction)->paginate(10);
    }
}