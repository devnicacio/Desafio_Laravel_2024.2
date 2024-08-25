<?php

use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

if(!function_exists('betterAdminForAdmins')){
    function betterAdminForAdmins($adminId){
        $admins = Admin::all();
        $adminChosen = $admins->first();
        $minor = $adminChosen->admins()->count();
        
        foreach($admins as $admin){
            $minorTest = $admin->admins()->count();

            if(($minorTest < $minor) && $admin->id != $adminId){
                $minor = $minorTest;
                $adminChosen = $admin;
            }
        }
        return $adminChosen->id;
    }
}


if(!function_exists('betterAdminforManagers')){
    function betterAdminforManagers() {
        $admins = Admin::all();
        $adminChosen = $admins->first();
        $minor = $adminChosen->admins()->count();
        
        foreach($admins as $admin){
            $minorTest = $admin->admins()->count();

            if(($minorTest < $minor)){
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