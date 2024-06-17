<?php 

namespace App\Gateways\Payments;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\PaymentLog;
use App\Traits\SaveLogTrait;

class CreditCardGateway implements PaymentGatewayInterface
{
    use SaveLogTrait;
    public function pay(array $data): string
    {
        $this->saveLog( "Cartão de Credito");
        return "Payd with Credit card";
    }
}