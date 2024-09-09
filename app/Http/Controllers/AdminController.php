<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardAdmin(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $msg = $request->session()->get('msg');

        return view('admin.dashboard', compact('msg'));
    }
}
