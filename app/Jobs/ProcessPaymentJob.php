<?php

namespace App\Jobs;

use App\Services\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;
    protected $paymentService;
    
    public function __construct(array $data, PaymentService $paymentService)
    {
        $this->data = $data;
        $this->paymentService = $paymentService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->paymentService->processPayment($this->data);
    }
}
