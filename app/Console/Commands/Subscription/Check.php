<?php

namespace App\Console\Commands\Subscription;

use App\Services\Subscription\SubscriptionService;
use Illuminate\Console\Command;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription check';

    /**
     * Execute the console command.
     */
    public function handle(SubscriptionService $subscriptionService): void
    {

        $this->info('Subscription start check');

        $count = $subscriptionService->startCheckSubscription();

        $this->info($count . ' subscriptions check started');

    }
}
