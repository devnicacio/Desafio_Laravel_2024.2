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
        'number' => $this->generateAccountNumber(),
        'balance' => fake()->randomFloat(2),
        'transferLimit' => fake()->randomFloat(2),
        'password' => Hash::make(fake()->randomNumber(6, true))
        ];
    }

    public function generateAccountNumber() {
        do{
            $number = strval(fake()->randomNumber(7, true));
        } while(DB::table('accounts')->where('number', $number)->exists());

        return $number;
    }
}
