<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Auth;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $account = Account::find($manager->account);
        return view('manager.dashboard', compact('account'));
    }

    public function userlist()
    {
        $manager = Auth::guard('manager')->user();
        $account = Account::find($manager->account);

        $users = $manager->users;

        return view('manager.userlist', compact('account', 'users'));
    }
}
