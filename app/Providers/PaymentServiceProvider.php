<?php

namespace App\Providers;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, function ($app) {            
            $methods = config("payments.gateways");
            $selectedGateway = $app->request->input("payment_method");
            $gatewayClass = $methods[$selectedGateway];

            return $app->make($gatewayClass);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
