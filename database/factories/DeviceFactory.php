<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'app_id' => $this->faker->randomNumber(),
            'language' => $this->faker->languageCode,
            'operating_system' => $this->faker->randomElement(['ios', 'android']),
            'client_token' => $this->faker->sha256,
        ];
    }
}
