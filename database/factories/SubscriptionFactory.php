<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{

    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->boolean(),
            'expire_date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'receipt' => $this->faker->sha256.$this->faker->randomNumber().$this->faker->randomNumber(),
        ];
    }
}
