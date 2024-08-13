<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country' => fake()->country(),
            'postalCode' => fake()->numerify('#####-###'),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'neighborhood' => fake()->sentence(2),
            'street' => fake()->streetName(),
            'number' => strval(fake()->randomNumber(4, false)),
            'complement' => fake()->sentence(),
        ];
    }
}
