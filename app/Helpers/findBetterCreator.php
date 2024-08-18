<?php

use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

if(!function_exists('findAdminWithLessAdmins')){
    function findAdminWithLessAdmins(){
        $adminChosen = Admin::get()->first();
        $minor = $adminChosen->admins()->count();

        $admins = Admin::all();
        foreach($admins as $admin){
                $aux = $admin->admins()->count();

                if($aux < $minor){
                    $minor = $aux;
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
            $aux = $admin->managers()->count();

            if($aux < $minor){
                $minor = $aux;
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
            $aux = $manager->managers()->count();

            if($aux < $minor){
                $minor = $aux;
                $managerChosen = $manager;
            }
        }
        return $managerChosen->id;
    }
}