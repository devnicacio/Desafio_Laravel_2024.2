<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Admin;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {

        $users = User::all();
        $managers = Manager::all();
        $admins = Admin::all();

        if($request->has('admin')){
            foreach($admins as $i=>$admin){
                Mail::to($admin->email, $admin->name)->send(new Contact([
                    'message' => $request->message,
                    'subject' => $request->subject,
                    'name' => $admin->name
                ]));
            }
        }

        if($request->has('manager')){
            foreach($managers as $i=>$manager){
                Mail::to($manager->email, $manager->name)->send(new Contact([
                    'message' => $request->message,
                    'subject' => $request->subject,
                    'name' => $manager->name
                ]));
            }
        }

        if($request->has('user')){
            foreach($users as $i=>$user){
                Mail::to($user->email, $user->name)->send(new Contact([
                    'message' => $request->message,
                    'subject' => $request->subject,
                    'name' => $user->name
                ]));
            }
        }
        return redirect()->back();
    }
}
