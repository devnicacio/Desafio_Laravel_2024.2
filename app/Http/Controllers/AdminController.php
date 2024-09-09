<?php

namespace App\Http\Controllers;

use App\Models\ManagerPendencie;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
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

    public function profileUpdate(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:managers,email,' . $admin->id,
            'country' => 'required|string|max:255',
            'postalCode' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:managers,phoneNumber,' . $admin->id,
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:managers,cpf,' . $admin->id,
            'photo' => 'nullable|image|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos."
        ]);

        $address = $admin->address()->first();

        if($request->file('photo'))
            $path = "storage/" . $request->file('photo')->store('images','public');
        else
            $path = $admin->photo;

        if($request->password)
            $password = Hash::make($request->password);
        else
            $password = $admin->password;

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

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
            'password' => $password
        ]);

        $request->session()->flash('msg', 'Dados atualizados com sucesso!');

        return redirect(route('admin-dashboard'));
    }

    public function deleteProfile()
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->id == 1) {
            return redirect()->back()->withErrors(['' => 'Você não pode excluir o primeiro administrador']);
        }
    
        $address = $admin->address()->first();

        $managerPendencies = $admin->pendencies()->get();
        $managers = $admin->managers()->get();
        $admins = $admin->admins()->get();

        if($managerPendencies->count() != 0){
            foreach($managerPendencies as $pendencie){
                $pendencie->delete();
            }
        }

        if($managers->count() != 0){
            foreach($managers as $manager){
                $manager->update([
                    'admin' => betterAdminForManagersExclusive($admin->id)
                ]);
            }
        }

        if($admins->count() != 0){
            foreach($admins as $admin){
                $admin->update([
                    'admin' => betterAdminForAdminsExclusive($admin->id)
                ]);
            }
        }

        if($admin->photo != 'images/safebank-default-profile-photo.png')
            unlink(public_path($admin->photo));

        $admin->delete();
        $address->delete();

        return redirect('/');
    }

    public function showUserList(Request $request)
    {
        $users = User::all();
        $msg = $request->session()->get('msg');

        return view('admin.show-user-list', compact('users', 'msg'));
    }

    public function showCreateUser()
    {
        return view('admin.show-create-user');
    }

    public function showUser(User $user)
    {
        $address = $user->address()->first();
        $accountUser = $user->account()->first();
        $manager = $user->manager()->first();

        return view('admin.show-user', compact('user', 'address', 'accountUser', 'manager'));
    }
}
