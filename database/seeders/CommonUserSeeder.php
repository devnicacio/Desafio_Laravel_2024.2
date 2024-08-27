<?php

namespace Database\Seeders;

use App\Models\CommonUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommonUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommonUser::factory(4)->create()->skip(1)->each(function($commonUser){
            $commonUser->manager = betterManagerForCommonUsers();
            $commonUser->save();
        });
    }
}
