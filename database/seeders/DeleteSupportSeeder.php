<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeleteSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::find(1)->delete();
        Address::find(1)->delete();
    }
}
