<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Jobs\EmailNotificationsJob;
use App\Mail\NotifyPayment;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;

class PaymentService
{
    protected $payment;
    protected $buyerService;
    protected $productService;
    protected $paymentGateway;
    public function __construct(
        Payment $payment,
        BuyerService $buyerService,
        ProductService $productService,
        PaymentGatewayInterface $paymentGateway
    ) {
        $this->payment = $payment;
        $this->buyerService = $buyerService;
        $this->productService = $productService;
        $this->paymentGateway = $paymentGateway;
    }

    function processPayment(array $data): Payment
    {
        $buyer = $this->buyerService->findByDocument($data["buyer_document"]);
        $product = $this->productService->findByCode($data["product_id"]);

        $paymentData = [
            "payment_method" => $data["payment_method"],
            "status" => "ok",
            "amount" => $data["amount"],
            "buyer_id" => $buyer->id,
            "product_id" => $product->id
        ];

        //Processa o pagamento no gateway referente ao tipo de pagamento
        $gatewayResponse =  $this->paymentGateway->pay($paymentData);
        dump($gatewayResponse);

        //registra no BD
        $paymentResponse = $this->payment->create($paymentData);

        //envia email
        EmailNotificationsJob::dispatch($buyer, $paymentData["amount"]);

        return $paymentResponse;
    }
}
