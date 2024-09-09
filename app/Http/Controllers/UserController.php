<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();

        $msg = $request->session()->get('msg');

        return view('user.dashboard', compact('account', 'msg'));
    }
}
