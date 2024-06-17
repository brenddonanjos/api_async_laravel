<?php

use App\Http\Controllers\BuyerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/payment", [PaymentController::class, "store"]);
Route::post("/product", [ProductController::class, "store"]);
Route::post("/buyer", [BuyerController::class, "store"]);