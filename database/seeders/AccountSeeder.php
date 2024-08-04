<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('accounts')->insert([
            'agency' => $faker->name,

            //VER COMO GERAR NÚMERO ALEATÓRIO
            //VER COMO FAZER ESSE NÚMERO SER ÚNICO
            //USAR FACTORY
            //FAZER TRYCATH E TRANSACTION
            //
        ]);
    }
}
