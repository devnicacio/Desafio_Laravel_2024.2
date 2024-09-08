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

if(!function_exists('betterAdminForManagers')){
    function betterAdminForManagers() {
        $admins = Admin::all();
        $adminChosen = $admins->first();
        $minor = $adminChosen->managers()->count();
        
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

if(!function_exists('betterManagerForCommonUsers')){
    function betterManagerForCommonUsers() {
        $managers = Manager::all();
        $managerChosen = $managers->first();
        $minor = $managerChosen->users()->count();
        
        foreach($managers as $manager){
            $minorTest = $manager->users()->count();

            if($minorTest < $minor){
                $minor = $minorTest;
                $managerChosen = $manager;
            }
        }
        return $managerChosen->id;
    }
}

if(!function_exists('betterManagerForCommonUsersExclusive')){
    function betterManagerForCommonUsersExclusive($managerId) {
        $managers = Manager::where('id', '!=', $managerId);
        $managerChosen = $managers->first();
        $minor = $managerChosen->users()->count();
        
        foreach($managers as $manager){
            $minorTest = $manager->users()->count();

            if($minorTest < $minor){
                $minor = $minorTest;
                $managerChosen = $manager;
            }
        }

        return $managerChosen->id;
    }
}