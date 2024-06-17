<?php 

namespace App\Gateways\Payments;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\PaymentLog;
use App\Traits\SaveLogTrait;

class BoletoGateway implements PaymentGatewayInterface
{
    use SaveLogTrait;
    public function pay(array $data) : string
    {
        $this->saveLog("Boleto");
        return "Payment with Boleto";
    }
}