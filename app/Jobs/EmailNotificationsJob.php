<?php

namespace App\Jobs;

use App\Mail\NotifyPayment;
use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private Buyer $buyer;
    private float $amount;
    public function __construct($buyer, $amount)
    {
        $this->buyer = $buyer;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [
            "amount" => $this->amount,
            "document" => $this->buyer->document
        ];
        //envia email
        Mail::to($this->buyer->email)->send(new NotifyPayment($data));
    }
}
