<?php

use Illuminate\Support\Facades\DB;


if(!function_exists('generateUnicNumber')){
    function generateUnicNumber($table, $column, $digits) {
        $faker = \Faker\Factory::create();
        
        do{
            $number = strval($faker->randomNumber($digits, true));
        } while(DB::table($table)->where($column, $number)->exists());

        return $number;
    }

    function generateUnicNumber($table, $column, $digits, $format) {
        $faker = \Faker\Factory::create();
        
        do{
            $number = $faker->numerify($format);
        } while(DB::table($table)->where($column, $number)->exists());

        return $number;
    }
}