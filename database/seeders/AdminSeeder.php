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
        Admin::factory(10)->create()->skip(2)->each(function ($admin){ //PULA OS DOIS PRIMEIROS PARA O PRIMEIRO ADMIN REFERENCIAR ELE MESMO E O SEGUNDO REFERENCIAR O PRIMEIRO COMO ADMIN CRIADOR 
            $admin->admin = betterAdminForAdmins($admin->id);
            $admin->save();
        });
    }
}