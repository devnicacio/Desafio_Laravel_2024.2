<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
        'agency' => fake()->numerify('####'),
        'number' => generateUnicNumber('accounts', 'number', '#######'),
        'balance' => fake()->randomFloat(2),
        'transferLimit' => fake()->randomFloat(2),
        ];
    }
}
