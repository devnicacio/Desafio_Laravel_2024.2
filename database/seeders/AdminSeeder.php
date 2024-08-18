<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory(10)->create()->each(function ($admin){
            $address = Address::inRandomOrder()->first();
            $admin->address = $address->id;
            $admin->admin = findAdminWithLessAdmins();
            $admin->save();
        });
    }
}
