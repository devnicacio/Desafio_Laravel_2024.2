<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use App\Models\ManagerPendencie;
use App\Models\Transfer;
use App\Models\User;
use App\Models\UserPendencie;
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

        $accountUser = $user->account()->first();

        return view('manager.show-user', compact('manager', 'account', 'address', 'user', 'accountUser'));
    }

    public function showEditUser(User $user)
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();
        $address = $user->address()->first();

        $accountUser = $user->account()->first();

        return view('manager.show-edit-user', compact('manager', 'account', 'address', 'user', 'accountUser'));
    }

    public function showEditManager()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        return view('manager.show-edit-manager', compact('account'));
    }

    public function updateManager(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $validAge = Carbon::now()->subYears(18)->format('d/m/Y');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:managers,email,' . $manager->id,
            'country' => 'required|string|max:255',
            'postalCode' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'complement' => 'nullable|string|max:255',
            'phoneNumber'=> 'required|string|max:255|unique:managers,phoneNumber,' . $manager->id,
            'birthdate' => 'required|date|before:' . $validAge,
            'cpf' => 'required|string|max:255|unique:managers,cpf,' . $manager->id,
            'photo' => 'nullable|image|max:255',
            'password' => 'nullable|string|max:255'
        ],[
            'birthdate.before' => "O usuário precisa ter mais de 18 anos."
        ]);

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

        return redirect(route('manager-user-list'));
    }

    public function deleteUser(User $user, Request $request)
    {
        if($user->photo != 'images/safebank-default-profile-photo.png')
            unlink(public_path($user->photo));
        
        $address = $user->address()->first();
        $account = $user->account()->first();

        $user->delete();
        $address->delete();
        $account->delete();

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

    public function showWithdraw()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        return view('manager.show-withdraw', compact('account'));
    }

    public function storeWithdraw(Request $request)
    {
        $manager = Auth::guard('manager')->user();

        $request->validate([
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        if (!(Hash::check($request->password, $manager->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $account = $manager->account()->first();

        $value = (double) $request->value;

        if($value > $account->balance)
            return redirect()->back()->withErrors(['value' => 'Saque acima do saldo da conta.']);
            
        $account->update([
            'balance' => $account->balance -= $value
        ]);

        $date = Carbon::now()->format('Y-m-d H:i:s');
        Transfer::create([
            'title' => "Saque",
            'senderAccount' => $account->number,
            'recipientAccount' => null,
            'value' => $value,
            'date' => $date
        ]);
        
        $request->session()->flash('msg', "Saque realizado com sucesso!");

        return redirect(route('manager-dashboard'));
    }

    public function showDeposit()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        return view('manager.show-deposit', compact('account'));
    }

    public function storeDeposit(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $accountManager = $manager->account()->first();

        $request->validate([
            'agency' => 'required|numeric|digits:4',
            'number' => 'required|numeric|digits:7',
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        $users = $manager->users()->get();
        $acchountChosen = null;

        if($request->number == $accountManager->number)
            $acchountChosen = $accountManager;
        else{
            foreach($users as $user){
                $accountUser = $user->account()->first();
                if(($accountUser->agency == $request->agency) && ($accountUser->number == $request->number))
                    $acchountChosen = $accountUser;
            }

            if ($acchountChosen == null) {
                return redirect()->back()->withErrors(['agency' => 'Os dados não correspondem à sua conta ou de seus usuários']);
            }
        }  

        if (!(Hash::check($request->password, $manager->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $value = (double) $request->value;
            
        $acchountChosen->update([
            'balance' => $acchountChosen->balance += $value
        ]);

        $date = Carbon::now()->format('Y-m-d H:i:s');
        Transfer::create([
            'title' => "Depósito",
            'senderAccount' => null,
            'recipientAccount' => $acchountChosen->number,
            'value' => $value,
            'date' => $date
        ]);

        $request->session()->flash('msg', "Depósito realizado com sucesso!");

        return redirect(route('manager-dashboard'));
    }

    public function showTransfer()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        return view('manager.show-transfer', compact('account'));
    }

    public function storeTransfer(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $senderAccount = $manager->account()->first();

        $request->validate([
            'agency' => 'required|numeric|digits:4',
            'number' => 'required|numeric|digits:7',
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        $recipientAccount = Account::where('number', $request->number)->first();
        $value = (double) $request->value;

        if(empty($recipientAccount))
            return redirect()->back()->withErrors(['number' => 'Conta não encontrada, verifique os dados informados']);

        if($recipientAccount->number == $senderAccount->number)
            return redirect()->back()->withErrors(['number' => 'Você não pode realizar transferência para sua própria conta']);

        if($value > $senderAccount->balance)
            return redirect()->back()->withErrors(['value' => 'ransferência acima do saldo da conta.']);
        
        if (!(Hash::check($request->password, $manager->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $date = Carbon::now()->format('Y-m-d H:i:s');
        $admin = $manager->admin()->first();
    
        if($value > $senderAccount->transferLimit){
            ManagerPendencie::create([
                'title' =>  "Transferência",
                'senderAccount' => $senderAccount->number,
                'recipientAccount' => $recipientAccount->number,
                'value' => $value,
                'date' => $date,
                'admin' => $admin->id
            ]);
            $request->session()->flash('msg', "Pendência gerada com sucesso (transferência acima do limite), aguarde a aprovação do admin. As informações para contato do admin são e-mail: $admin->email e telefone: $admin->phoneNumber");
        }
        else{
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
            $request->session()->flash('msg', "Transferência realizada com sucesso!");
        }

        return redirect(route('manager-dashboard'));
    }

    public function showLoan()
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();

        $approvedLoan = ManagerPendencie::where('title', "Empréstimo")->where('recipientAccount', $account->number)->where('status', 1)->first();

        return view('manager.show-loan', compact('account', 'approvedLoan'));
    }

    public function storeLoan(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $recipientAccount = $manager->account()->first();

        $request->validate([
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        if (!(Hash::check($request->password, $manager->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $haveLoan = ManagerPendencie::where('title', "Empréstimo")->where('recipientAccount', $recipientAccount->number)->where('status', 0)->first();
        $admin = $manager->admin()->first();

        if(!empty($haveLoan))
            return redirect()->back()->withErrors(['value' => "Você já tem um empréstimo em aberto, aguarde a aprovação pelo administrador. Os dados para contato do administrador são email: $admin->email e telefone: $admin->phoneNumber"]);

        $value = (double) $request->value;
        $date = Carbon::now()->format('Y-m-d H:i:s');

        ManagerPendencie::create([
            'title' =>  "Empréstimo",
            'senderAccount' => null,
            'recipientAccount' => $recipientAccount->number,
            'value' => $value,
            'date' => $date,
            'admin' => $admin->id
        ]);

        $request->session()->flash('msg', "Pedido de empréstimo realizado com sucesso! Aguarde a aprovação pelo administrador. Os dados para contato do administrador são email: $admin->email e telefone: $admin->phoneNumber");

        return redirect(route('manager-dashboard'));
    }

    public function payLoan(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $account = $manager->account()->first();
        $approvedLoan = ManagerPendencie::where('title', "Empréstimo")->where('recipientAccount', $account->number)->where('status', 1)->first();

        $request->validate([
            'password' => 'required|string|max:255',
        ]);

        if($approvedLoan->value > $account->balance)
            return redirect()->back()->withErrors(['value' => 'Saldo insuficiente.']);

        if (!(Hash::check($request->password, $manager->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $account->update([
            'balance' => $account->balance -= $approvedLoan->value
        ]);

        $date = Carbon::now()->format('Y-m-d H:i:s');
        Transfer::create([
            'title' => "Pagamento de empréstimo",
            'senderAccount' => null,
            'recipientAccount' => $account->number,
            'value' => $approvedLoan->value,
            'date' => $date
        ]);

        $approvedLoan->delete();

        $request->session()->flash('msg', "Saque realizado com sucesso!");

        return redirect(route('manager-dashboard'));
    }
}
