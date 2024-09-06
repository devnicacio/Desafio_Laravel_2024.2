<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
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
            'email'=> generateUnicEmail('admins', 'email'),
            'password' => Hash::make('abc123*'),
            'address' => Address::factory()->create()->id,
            'phoneNumber' => $fakerBR->cellphoneNumber(),
            'birthdate' => fake()->dateTimeBetween('-100 years', '-18 years'),
            'cpf' => $fakerBR->cpf(),
            'photo' => "images/safebank-default-profile-photo.png",
            'admin'=> 1,
        ];
    }
}
