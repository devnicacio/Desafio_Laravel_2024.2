<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardAdmin(Request $request)
    {
        $msg = $request->session()->get('msg');

        return view('admin.dashboard', compact('msg'));
    }

    public function showEditProfile()
    {
        return view('admin.show-edit-profile');
    }
}
