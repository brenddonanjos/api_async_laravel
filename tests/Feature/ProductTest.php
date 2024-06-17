<?php

namespace Tests\Feature;

use App\Services\ProductService;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_product_success(): void
    {
        $productService = new ProductService();
        $productService->deleteByCode("ABCD1234");

        $response = $this->post('api/product', [
            "code" => "ABCD1234",
            "name" => "Test product",
            "description" => "Description test product"
        ]);
        $response->assertStatus(201);

        $productService->deleteByCode("ABCD1234");
    }

    public function test_product_fail(): void
    {
        $response = $this->post('api/product', [
            "code" => "",
            "name" => "Test product",
            "description" => "Description test product"
        ]);
        $response->assertStatus(302);
    }

    public function test_product_conflict(): void
    {
        $productService = new ProductService();
        $product = $productService->create([
            "code" => "ABCD1234",
            "name" => "Test product",
            "description" => "Description test product"
        ]);

        $response = $this->post('api/product', [
            "code" => "ABCD1234",
            "name" => "Test product",
            "description" => "Description test product"
        ]);
        $response->assertStatus(400);
        
        $product->refresh();
        $product->delete();
    }
}
