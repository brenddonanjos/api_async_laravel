<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    public function pay(array $data): string;
}
