<?php

namespace App\Services\Payment;

class PaymentResponse
{
    public function __construct(public bool $status, public string $expire_date)
    {
        //. . .
    }

}
