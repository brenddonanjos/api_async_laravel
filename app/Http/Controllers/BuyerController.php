<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyerRequest;
use App\Services\BuyerService;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function store(BuyerRequest $request, BuyerService $buyerService) {
        try {
            $data = $request->all();
            $buyer = $buyerService->create($data);
            return $this->success("Buyer created successfully", $buyer, 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }
}
