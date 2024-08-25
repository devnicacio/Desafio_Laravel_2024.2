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
        Admin::factory(4)->create()->skip(2)->each(function ($admin){ //TODOS OS ADMINS SÃO INICIALMENTE CRIADOS COM ADMIN = 1 (CRIADOR)
            $address = Address::inRandomOrder()->first();
            $admin->address = $address->id;
            $admin->admin = betterAdminForAdmins($admin->id);
            $admin->save();
        });
    }
}