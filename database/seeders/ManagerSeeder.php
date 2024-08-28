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
        Manager::factory(10)->create()->skip(1)->each(function($manager){
            $manager->admin = betterAdminForManagers();
            $manager->save();
        });
    }
}
