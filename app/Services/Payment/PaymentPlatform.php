<?php

namespace App\Services\Payment;

use App\Services\Payment\PaymentResponse;
interface PaymentPlatform
{
    public function validateReceipt(string $receipt): PaymentResponse;

    public function checkSubscription(string $receipt): SubscriptionResponse;

}
