<?php

namespace App\Traits;

use App\Models\PaymentLog;

trait SaveLogTrait
{
    public function saveLog($message)
    {
        PaymentLog::create(["message" => $message]);
    }
}
