<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommonUser>
 */
class CommonUserFactory extends Factory
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
            'email' => , 
            'password' => , 
            'account' => , 
            'manager' => , 
            'address' => , 
            'photo' => , 
            'phoneNumber' => , 
            'birthdate' => , 
            'cpf' =>  
        ];
    }
}
