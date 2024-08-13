<?php

use Illuminate\Support\Facades\DB;


if(!function_exists('generateUnicNumber')){
    function generateUnicEmail($table, $column) {
        $faker = \Faker\Factory::create();
        
        do{
            $email = $faker->safeEmail();
        } while(DB::table($table)->where($column, $email)->exists());

        return $email;
    }
}