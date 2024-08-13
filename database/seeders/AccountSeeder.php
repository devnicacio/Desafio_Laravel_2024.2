<?php

namespace Database\Seeders;

use App\Models\Adress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Address;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::factory(20)->create();
        Address::factory(20)->create();
    }
}
