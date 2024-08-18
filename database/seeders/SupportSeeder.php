<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'country' => 'Brasil',
            'postalCode' => 'Brasil',
            'state' => 'Brasil',
            'city' => 'Brasil',
            'neighborhood' => 'Brasil',
            'street' => 'Brasil',
            'number' => 'Brasil',
            'complement' => 'Brasil',
        ]);

        Account::create([
            'agency' => '123',
            'number' => 'Brazil',
            'balance' => 1,
            'transferLimit' => 1,
            'password' => 'Brazil',
        ]);
    }
}
