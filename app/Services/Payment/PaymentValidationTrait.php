<?php

namespace App\Services\Payment;

trait PaymentValidationTrait
{

    private function checkReceiptIsValid($receipt): bool
    {
        return substr($receipt, -1)  % 2 !== 0;
    }

    private function checkRateLimit($receipt): bool
    {

        return substr($receipt, -2) % 6 == 0;
    }

    private function getExpireDate(bool $status): string
    {

        $date = now('-6')
            ->setTimezone('UTC');

        if ($status){
            $date = $date->addDays(30);
        }else{
            $date = $date->subDays(30);
        }

        return $date;
    }

}
