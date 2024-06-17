<?php

namespace App\Services;

use App\Models\Buyer;

class BuyerService
{

    protected $buyer;
    public function __construct(Buyer $buyer)
    {
        $this->buyer = $buyer;
    }

    public function create(array $data): Buyer
    {
        return $this->buyer->create($data);
    }

    public function findByDocument(string $document): Buyer
    {
        return $this->buyer->where("document", $document)->first();
    }
}
