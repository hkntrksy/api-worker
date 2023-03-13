<?php

namespace App\Services\Payment;

use Exception;

class PaymentFactory
{
    /**
     * @param string $platform
     * @return PaymentPlatform
     * @throws Exception
     */
    public static function createPaymentPlatform(string $platform): PaymentPlatform
    {
        return match ($platform) {
            'ios' => new IOSPaymentPlatform(),
            'google' => new GooglePaymentPlatform(),
            default => throw new Exception('Invalid platform specified.'),
        };
    }

}
