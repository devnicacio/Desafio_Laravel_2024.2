<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manager::factory(1)->create()->skip(0)->each(function($manager){
            $manager->admin = betterAdminforManagers();
            $manager->save();
        });
    }
}
