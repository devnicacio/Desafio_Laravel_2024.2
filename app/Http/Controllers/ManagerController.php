<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use App\Models\User;
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
        $users = $manager->users()->get();
        $account = $manager->account()->first();

        return view('manager.user-list', compact('account', 'users'));
    }

    public function showUser(User $user)
    {
        $manager = Auth::guard('manager')->user();
        $account = Account::find($manager->account);
        $address = Address::find($user->address);

        return view('manager.show-user', compact('manager', 'account', 'user', 'address'));
    }

    public function showEdit(User $user)
    {
        $manager = Auth::guard('manager')->user();
        $account = Account::find($manager->account);
        $address = Address::find($user->address);

        return view('manager.show-edit', compact('manager', 'account', 'user', 'address'));
    }
}
