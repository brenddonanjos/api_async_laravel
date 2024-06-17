<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Jobs\EmailNotificationsJob;
use App\Models\Payment;
use App\Traits\SaveLogTrait;
use Exception;
use Illuminate\Support\Facades\Mail;

class PaymentService
{
    use SaveLogTrait;

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
        try {
            $buyer = $this->buyerService->findByDocument($data["buyer_document"]);
            if ($buyer == null) {
                throw new Exception("Buyer not found.");
            }
            $product = $this->productService->findByCode($data["product_id"]);
            if ($product == null) {
                throw new Exception("Product not found.");
            }

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
        } catch (\Throwable $th) {
            $this->saveLog("Erro: " . $th->getMessage());
            dump("Erro: " . $th->getMessage());
            return null;
        }
    }
}
