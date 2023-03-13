<?php

namespace App\Services\Subscription;

use App\Jobs\Subscription\CheckJob;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Services\Payment\PaymentFactory;
use Exception;

class SubscriptionService
{

    public function __construct(
        private SubscriptionRepository $subscriptionRepository
    )
    {
        //..
    }

    public function startCheckSubscription(): int
    {

        $subscriptions = $this->subscriptionRepository->getExpiredSubscriptions();

        foreach ($subscriptions as $subscription) {

            CheckJob::dispatch($subscription)->onQueue('default');

        }

        return $subscriptions->count();

    }

    public function checkSubscription(Subscription $subscription): void
    {

        try {

            $paymentPlatform = PaymentFactory::createPaymentPlatform($subscription->device->operating_system);

            $checkSubscription = $paymentPlatform->checkSubscription($subscription->receipt);

            $subscription->status = false;

            $this->subscriptionRepository->updateSubscription($subscription);

        }catch (Exception $e) {

            CheckJob::dispatch($subscription)->delay(now()->addMinutes(5))->onQueue('default');;

        }


    }

}
