<?php

namespace Database\Seeders;

use App\Models\Adress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Address;
use App\Models\Admin;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::factory(10)->create();
        Address::factory(10)->create();
        Admin::factory(10)->create();
    }
}
