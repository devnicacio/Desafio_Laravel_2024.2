<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Address;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerBR = \Faker\Factory::create('pt_BR');

        return [
            'name' => $fakerBR->name(), 
            'email' => generateUnicEmail('admins', 'email'),
            'password' => Hash::make('abc123*'),
            'account' => Account::factory()->create()->id,
            'manager' => 1,
            'address' => Address::factory()->create()->id,
            'photo' => "images/safebank-default-profile-photo.png",
            'phoneNumber' => $fakerBR->cellphoneNumber(),
            'birthdate' => fake()->dateTimeBetween('-100 years', '-18 years'),
            'cpf' => $fakerBR->cpf()
        ];
    }
}
