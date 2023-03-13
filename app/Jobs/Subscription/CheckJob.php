<?php

namespace App\Jobs\Subscription;

use App\Models\Subscription;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Subscription $subscription)
    {
        //..
    }

    /**
     * Execute the job.
     */
    public function handle(SubscriptionService $subscriptionService): void
    {
        $subscriptionService->checkSubscription($this->subscription);
    }
}
