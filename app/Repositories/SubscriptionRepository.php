<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{

    /**
     * @param Subscription $model
     */
    public function __construct(private Subscription $model)
    {
        //..
    }

    public function createSubscription(Subscription $subscription): mixed
    {
        return $subscription->save();
    }

    public function checkSubscriptionByDeviceId(int $deviceId): mixed
    {

        return $this->model
            ->where('device_id', $deviceId)
            ->where('status', true)
            ->where('expire_date', '>', now('-6')->setTimezone('UTC'))
            ->first();

    }

    public function getExpiredSubscriptions(): mixed
    {

        return $this->model
            ->with('device')
            ->where('status', true)
            ->where('expire_date', '<', now('-6')->setTimezone('UTC'))
            ->get();

    }

    public function updateSubscription(Subscription $subscription): mixed
    {
        return $subscription->save();
    }

}
