<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Jobs\ProcessPaymentJob;
use App\Models\Payment;
use App\Services\BuyerService;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request, PaymentService $paymentService)
    {
        $data = $request->all();
        ProcessPaymentJob::dispatch($data, $paymentService);

        return $this->processing("Payment request received and is being processed.");
    }
}
