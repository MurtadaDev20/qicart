<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function getFiltered(array $filters);
}

?>