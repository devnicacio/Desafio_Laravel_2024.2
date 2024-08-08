<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        'agency' => strval(fake()->randomNumber(4, true)),
        'number' => generateUnicNumber('accounts', 'number', 7),
        'balance' => fake()->randomFloat(2),
        'transferLimit' => fake()->randomFloat(2),
        'password' => Hash::make('000000')
        ];
    }
}
