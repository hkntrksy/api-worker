<?php

namespace App\Services\Payment;

class IOSPaymentPlatform implements PaymentPlatform
{

    use PaymentValidationTrait;
    public function validateReceipt(string $receipt): PaymentResponse
    {

        $status = $this->checkReceiptIsValid($receipt);
        $expireDate = $this->getExpireDate($status);

        return new PaymentResponse($status, $expireDate);

    }

    /**
     * @param string $receipt
     * @return SubscriptionResponse
     * @throws \Exception
     */
    public function checkSubscription(string $receipt): SubscriptionResponse
    {

        $rateLimit = $this->checkRateLimit($receipt);

        if ($rateLimit){
            throw new \Exception('Rate limit exceeded');
        }

        return new SubscriptionResponse(true);

    }
}
