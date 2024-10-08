<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(30)->create()->skip(1)->each(function($commonUser){
            $commonUser->manager = betterManagerForCommonUsers();
            $commonUser->save();
        });
    }
}
