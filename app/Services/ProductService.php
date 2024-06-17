<?php

namespace App\Services;

use App\Models\Product;

class ProductService {

    public function create(array $data) : Product
    {
        return Product::create($data);
    }

    public function findByCode(string $code) : Product
    {
        return Product::where("code", $code)->firstOrFail();
    }
    public function deleteByCode(string $code) : bool
    {
        return Product::where("code", $code)->delete();
    }
}