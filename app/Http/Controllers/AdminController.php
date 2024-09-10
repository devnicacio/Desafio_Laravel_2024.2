<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Manager;
use App\Models\ManagerPendencie;
use App\Models\Transfer;
use App\Models\User;
use App\Models\UserPendencie;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            foreach($managers as $manager){
                $manager->update([
                    'admin' => betterAdminForManagersExclusive($admin->id)
                ]);
                $manager->refresh();
            }
        

  
            foreach($managerPendencies as $pendencie){
                $pendencie->delete();
            }


            foreach($admins as $relatedAdmin){
                $relatedAdmin->update([
                    'admin' => betterAdminForAdminsExclusive($admin->id)
                ]);
                $relatedAdmin->refresh();
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

    public function showEditUser(User $user)
    {
        $address = $user->address()->first();
        $accountUser = $user->account()->first();

        return view('admin.show-edit-user', compact('address', 'user', 'accountUser'));
    }

    public function updateUser(User $user, Request $request){
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:users,phoneNumber,' . $user->id,
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:users,cpf,' . $user->id,
            'photo' => 'nullable|image|max:255',
            'transferLimit' => 'required|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos.",
        ]);

        $address = $user->address()->first();
        $account = $user->account()->first();

        if($request->file('photo')){
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

        $account->update([
            'transferLimit' => $request->transferLimit,
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

        return redirect(route('admin-show-user-list'));
    }

    public function deleteUser(User $user, Request $request)
    {
        if($user->photo != 'images/safebank-default-profile-photo.png')
        unlink(public_path($user->photo));
    
        $address = $user->address()->first();
        $account = $user->account()->first();

        $managerPendencies = ManagerPendencie::where('senderAccount', $account->number)->orWhere('recipientAccount', $account->number)->get();
        $usersPendencies = UserPendencie::where('senderAccount', $account->number)->orWhere('recipientAccount', $account->number)->get();

        if(!empty($managerPendencies)){
            foreach($managerPendencies as $pendencie){
                $pendencie->delete();
            }
        }

        if(!empty($usersPendencies)){
            foreach($usersPendencies as $pendencie){
                $pendencie->delete();
            }
        }

        $user->delete();
        $address->delete();
        $account->delete();

        $request->session()->flash('msg', "Usuário excluído com sucesso!");

        return redirect(route('admin-show-user-list'));
    }

    public function createUser(Request $request)
    {
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:users,phoneNumber',
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:users,cpf',
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
            'manager' => betterManagerForCommonUsers(),
            'address' => $address->id,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
        ]);

        $request->session()->flash('msg', "Usuário criado com sucesso!");

        return redirect(route('admin-show-user-list'));
    }

    public function showManagerList(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $users = $admin->managers()->get();
        $msg = $request->session()->get('msg');

        return view('admin.show-manager-list', compact('users', 'msg'));
    }

    public function showManager(Manager $user)
    {
        $address = $user->address()->first();
        $accountUser = $user->account()->first();
        $admin = $user->admin()->first();

        return view('admin.show-manager', compact('user', 'address', 'accountUser', 'admin'));
    }

    public function showEditManager(Manager $user)
    {
        $address = $user->address()->first();
        $accountUser = $user->account()->first();

        return view('admin.show-edit-manager', compact('address', 'user', 'accountUser'));
    }

    public function updateManager(Manager $user, Request $request)
    {
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:managers,email,' . $user->id,
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:managers,phoneNumber,' . $user->id,
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:managers,cpf,' . $user->id,
            'photo' => 'nullable|image|max:255',
            'transferLimit' => 'required|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos.",
        ]);

        $address = $user->address()->first();
        $account = $user->account()->first();

        if($request->file('photo')){
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

        $account->update([
            'transferLimit' => $request->transferLimit,
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

        return redirect(route('admin-show-manager-list'));
    }

    public function deleteManager(Manager $user, Request $request)
    {
        if($user->photo != 'images/safebank-default-profile-photo.png')
            unlink(public_path($user->photo));
    
        $address = $user->address()->first();
        $account = $user->account()->first();

        $managerPendencies = ManagerPendencie::where('senderAccount', $account->number)->orWhere('recipientAccount', $account->number)->get();
        $usersPendencies = UserPendencie::where('senderAccount', $account->number)->orWhere('recipientAccount', $account->number)->get();

        if(!empty($managerPendencies)){
            foreach($managerPendencies as $pendencie){
                $pendencie->delete();
            }
        }

        if(!empty($usersPendencies)){
            foreach($usersPendencies as $pendencie){
                $pendencie->delete();
            }
        }

        $commonUsers = $user->users()->get();

        if(!empty($commonUsers)){
            foreach($commonUsers as $commonUser){
                $commonUser->update([
                    'manager' => betterManagerForCommonUsersExclusive($user->id),
                ]);
            }
        }

        $user->delete();
        $address->delete();
        $account->delete();

        $request->session()->flash('msg', "Gerente excluído com sucesso!");

        return redirect(route('admin-show-manager-list'));
    }

    public function showCreateManager()
    {
        return view('admin.show-create-manager');
    }

    public function createManager(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:managers,email',
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:managers,phoneNumber',
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:managers,cpf',
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

        Manager::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account' =>  $account->id,
            'admin' => $admin->id,
            'address' => $address->id,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
        ]);

        $request->session()->flash('msg', "Usuário criado com sucesso!");

        return redirect(route('admin-show-manager-list'));
    }

    public function showAdminList(Request $request){
        $users = Admin::all();
        $msg = $request->session()->get('msg');
        $admin = Auth::guard('admin')->user();
        $creator = $admin->admin;

        return view('admin.show-admin-list', compact('users', 'msg', 'creator'));
    }
    public function showAdmin(Manager $user){
        $address = $user->address()->first();
        $admin = $user->admin()->first();

        return view('admin.show-admin', compact('user', 'address', 'admin'));
    }
    public function showEditAdmin(Admin $user){
        $address = $user->address()->first();

        return view('admin.show-edit-admin', compact('address', 'user'));
    }

    public function showCreateAdmin(){
        return view('admin.show-create-admin');
    }
    
    public function createAdmin(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:admins,phoneNumber',
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:admins,cpf',
            'photo' => 'nullable|image|max:255',
            'password' => 'required|string|max:255',
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

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $admin->id,
            'address' => $address->id,
            'phoneNumber'=> $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'photo' => $path,
        ]);

        $request->session()->flash('msg', "Administrador criado com sucesso!");

        return redirect(route('admin-show-admin-list'));
    }

    public function updateAdmin(Request $request, Admin $user)
    {
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,admin,' . $user->id,
            'country' => 'required|string|max:255',
            'postalCode' => 'required|regex:/^[0-9\-]+$/|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:admins,phoneNumber,' . $user->id,
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:admins,cpf,' . $user->id,
            'photo' => 'nullable|image|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos.",
        ]);

        $address = $user->address()->first();

        if($request->file('photo')){
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

        $request->session()->flash('msg', "Dados do administrador $user->name atualizados com sucesso!");

        return redirect(route('admin-show-admin-list'));
    }

    public function deleteAdmin(Admin $user, Request $request)
    {
        if($user->photo != 'images/safebank-default-profile-photo.png')
            unlink(public_path($user->photo));
    
        $address = $user->address()->first();

        $managers = $user->managers()->get();
        $admins = $user->admins()->get();

        if(!empty($managers)){
            foreach($managers as $manager){
                $manager->update([
                    'admin' => betterAdminForManagersExclusive($user->id),
                ]);
            }
        }

        if(!empty($admins)){
            foreach($admins as $admin){
                $admin->update([
                    'admin' => betterAdminForAdminsExclusive($user->id),
                ]);
            }
        }

        $user->delete();
        $address->delete();

        $request->session()->flash('msg', "Administrador excluído com sucesso!");

        return redirect(route('admin-show-admin-list'));
    }

    public function showPendencies(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $pendencies = $admin->pendencies()->get();
        $transferPendencies = $pendencies->where('title', "Transferência");

        $msg = $request->session()->get('msg');

        return view('admin.show-pendencies', compact('transferPendencies', 'msg', 'admin'));
    }

    public function acceptPendencie(ManagerPendencie $transferPendencie, Request $request)
    {
        $senderAccount = Account::where('number', $transferPendencie->senderAccount)->first();
        $recipientAccount = Account::where('number', $transferPendencie->recipientAccount)->first();
        $value = $transferPendencie->value;

        $date = Carbon::now()->format('Y-m-d H:i:s');
    
        $senderAccount->update([
            'balance' => $senderAccount->balance -= $value
        ]);

        $recipientAccount->update([
            'balance' => $recipientAccount->balance += $value
        ]);

        Transfer::create([
            'title' => "Transferência",
            'senderAccount' => $senderAccount->number,
            'recipientAccount' => $recipientAccount->number,
            'value' => $value,
            'date' => $date
        ]);

        $transferPendencie->delete();

        $request->session()->flash('msg', "Transferência aceita com sucesso!");

        return redirect(route('admin-show-pendencies'));
    }

    public function denyPendencie(ManagerPendencie $transferPendencie, Request $request)
    {
        $transferPendencie->delete();

        $request->session()->flash('msg', "Transferência recusada com sucesso!");

        return redirect(route('admin-show-pendencies'));
    }

    public function showLoans(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $loans = $admin->pendencies()->get();
        $loanlist = $loans->where('title', "Empréstimo")->where('status', 0);

        $msg = $request->session()->get('msg');

        return view('admin.show-loan-list', compact('loanlist', 'msg', 'admin'));
    }

    public function acceptLoan(ManagerPendencie $loan, Request $request)
    {
        $account = Account::where('number', $loan->recipientAccount)->first();

        $account->update([
            'balance' => $account->balance += $loan->value
        ]);

        $loan->update([
            'status' => 1
        ]);

        $request->session()->flash('msg', "Empréstimo aceito com sucesso!");

        return redirect(route('admin-show-loans'));
    }

    public function denyLoan(ManagerPendencie $loan, Request $request)
    {
        $loan->delete();

        $request->session()->flash('msg', "Empréstimo recusado com sucesso!");

        return redirect(route('admin-show-loans'));
    }
}
