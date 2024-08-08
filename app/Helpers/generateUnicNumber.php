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
}