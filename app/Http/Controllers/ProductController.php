<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(ProductRequest $request, ProductService $productService)
    {
        try {
            $data = $request->all();
            $product = $productService->create($data);
            return $this->success("Product created successfully", $product, 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }
}
