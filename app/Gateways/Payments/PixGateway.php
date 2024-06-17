<?php 

namespace App\Gateways\Payments;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\PaymentLog;
use App\Traits\SaveLogTrait;

class PixGateway implements PaymentGatewayInterface
{
    use SaveLogTrait;
    public function pay(array $data) : string
    {
        $this->saveLog("Pix");
        return "Paid with Pix";
    }
}