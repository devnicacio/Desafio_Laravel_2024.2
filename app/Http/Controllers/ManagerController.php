<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        $msg = $request->session()->get('msg');

        return view('manager.dashboard', compact('account', 'msg'));
    }

    public function userlist(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();
        $users = $manager->users()->get();
        $msg = $request->session()->get('msg');

        return view('manager.user-list', compact('account', 'users', 'msg'));
    }

    public function showUser(User $user)
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();
        $address = $user->address()->first();

        return view('manager.show-user', compact('manager', 'account', 'address', 'user'));
    }

    public function showEditUser(User $user)
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();
        $address = $user->address()->first();

        return view('manager.show-edit-user', compact('manager', 'account', 'address', 'user'));
    }

    public function showEditManager()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        return view('manager.show-edit-manager', compact('account'));
    }

    public function updateManager(Request $request)
    {
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'postalCode' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255',
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255',
            'photo' => 'required|image|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos."
        ]);

        $manager = Auth::guard('manager')->user();
        $address = $manager->address()->first();

        if($request->file('photo'))
            $path = "storage/" . $request->file('photo')->store('images','public');
        else
            $path = $manager->photo;

        if($request->password)
            $password = Hash::make($request->password);
        else
            $password = $manager->password;

        $address->update([
            'country' => $request->country,
            'postalCode' => $request->postalCode,
            'state' => $request->state,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
        ]);

        $manager->update([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
            'password' => $password
        ]);

        $request->session()->flash('msg', 'Dados atualizados com sucesso!');

        return redirect(route('manager-dashboard'));
    }

    public function updateUser(User $user, Request $request)
    {
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255',
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255',
            'photo' => 'nullable|image|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos."
        ]);

        $address = $user->address()->first();

        if($request->file('photo')){
            unlink(public_path($user->photo));
            $path = "storage/" . $request->file('photo')->store('images','public');
        }
        else
            $path = $user->photo;

        if($request->password)
            $password = Hash::make($request->password);
        else
            $password = $user->password;

        $address->update([
            'country' => $request->country,
            'postalCode' => $request->postalCode,
            'state' => $request->state,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
            'password' => $password
        ]);

        $request->session()->flash('msg', "Dados do usuário $user->name atualizados com sucesso!");

        return redirect(route('manager-user-list'));
    }

    public function deleteUser(User $user, Request $request)
    {
        if($user->photo != 'images/safebank-default-profile-photo.png')
            unlink(public_path($user->photo));
        
        $user->delete();

        $request->session()->flash('msg', "Usuário excluído com sucesso!");

        return redirect(route('manager-user-list'));
    }

    public function showCreateUser()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        return view('manager.show-create-user', compact('account'));
    }

    public function storeUser(Request $request)
    {
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255',
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255',
            'photo' => 'nullable|image|max:255',
            'password' => 'required|string|max:255',
            'agency' => 'required|integer|digits:4',
            'transferLimit' => 'required|regex:/^\d+([.,]\d{1,2})?$/'
        ], [
            'birthdate.before' => "O usuário precisa ter mais de 18 anos."
        ]);

        if($request->file('photo')){
            $path = "storage/" . $request->file('photo')->store('images','public');
        }
        else{
            $photo = new File(public_path('images/safebank-default-profile-photo.png'));
            $photoName = $photo->hashName();
            Storage::disk('public')->putFileAs('images', $photo, $photoName);
            $path = "storage/images/" . $photoName;
        }

        $manager = Auth::guard('manager')->user();

        $account = Account::create([
            'agency' => $request->agency,
            'number' => generateUnicNumber('accounts', 'number', '#######'),
            'balance' => 0,
            'transferLimit' => $request->transferLimit
        ]);

        $address = Address::create([
            'country' => $request->country,
            'postalCode' => $request->postalCode,
            'state' => $request->state,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account' =>  $account->id,
            'manager' => $manager->id,
            'address' => $address->id,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
        ]);

        $request->session()->flash('msg', "Usuário criado com sucesso!");

        return redirect(route('manager-user-list'));
    }
}
