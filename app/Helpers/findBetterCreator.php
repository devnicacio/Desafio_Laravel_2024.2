<?php

use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

if(!function_exists('findAdminWithLessAdmins')){
    function findAdminWithLessAdmins($adminId){
        $adminChosen = Admin::get()->first();
        $minor = $adminChosen->admins()->count();

        $admins = Admin::all();
        foreach($admins as $admin){
                $minorTest = $admin->admins()->count();

                if(($minorTest < $minor) && $admin->id != $adminId){
                    $minor = $minorTest;
                    $adminChosen = $admin;
                }
            }
            return $adminChosen->id;
        }
        return 1;
}


if(!function_exists('findBetterAdmin')){
    function findBetterAdmin() {
        $adminChosen = Admin::get()->first();
        $minor = $adminChosen->managers()->count();

        $admins = Admin::skip(1)->get();
        foreach($admins as $admin){
            $minorTest = $admin->managers()->count();

            if($minorTest < $minor){
                $minor = $minorTest;
                $adminChosen = $admin;
            }
        }
        return $adminChosen->id;
    }
}

if(!function_exists('findBetterManager')){
    function findBetterManager() {
        $managerChosen = Manager::get()->first();
        $minor = $managerChosen->managers()->count();

        $managers = Manager::skip(1)->get();
        foreach($managers as $manager){
            $minorTest = $manager->managers()->count();

            if($minorTest < $minor){
                $minor = $minorTest;
                $managerChosen = $manager;
            }
        }
        return $managerChosen->id;
    }
}