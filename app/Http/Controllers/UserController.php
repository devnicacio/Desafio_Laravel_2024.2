<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ManagerPendencie;
use App\Models\Transfer;
use App\Models\UserPendencie;
use Auth;
use Carbon\Carbon;
use Hash;
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

    public function showWithdraw()
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();

        return view('user.show-withdraw', compact('account'));
    }

    public function storeWithdraw(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        if (!(Hash::check($request->password, $user->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $account = $user->account()->first();

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

        return redirect(route('user-dashboard'));
    }

    public function showDeposit()
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();

        return view('user.show-deposit', compact('account'));
    }

    public function storeDeposit(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'agency' => 'required|numeric|digits:4',
            'number' => 'required|numeric|digits:7',
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        if (!(Hash::check($request->password, $user->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $value = (double) $request->value;
        $recipientAccount = Account::where('number', $request->number)->first();
            
        $recipientAccount->update([
            'balance' => $recipientAccount->balance += $value
        ]);

        $date = Carbon::now()->format('Y-m-d H:i:s');
        Transfer::create([
            'title' => "Depósito",
            'senderAccount' => null,
            'recipientAccount' => $recipientAccount->number,
            'value' => $value,
            'date' => $date
        ]);

        $request->session()->flash('msg', "Depósito realizado com sucesso!");

        return redirect(route('user-dashboard'));
    }

    public function showTransfer()
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();

        return view('user.show-transfer', compact('account'));
    }

    public function storeTransfer(Request $request)
    {
        $user = Auth::guard('web')->user();
        $senderAccount = $user->account()->first();

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
            return redirect()->back()->withErrors(['value' => 'Transferência acima do saldo da conta.']);
        
        if (!(Hash::check($request->password, $user->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $date = Carbon::now()->format('Y-m-d H:i:s');
        $manager = $user->manager()->first();
    
        if($value > $senderAccount->transferLimit){
            UserPendencie::create([
                'title' =>  "Transferência",
                'senderAccount' => $senderAccount->number,
                'recipientAccount' => $recipientAccount->number,
                'value' => $value,
                'date' => $date,
                'manager' => $manager->id
            ]);
            $request->session()->flash('msg', "Pendência gerada com sucesso (transferência acima do limite), aguarde a aprovação do admin. As informações para contato do admin são e-mail: $manager->email e telefone: $manager->phoneNumber");
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

        return redirect(route('user-dashboard'));
    }

    public function showLoan()
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();

        $approvedLoan = UserPendencie::where('title', "Empréstimo")->where('recipientAccount', $account->number)->where('status', 1)->first();

        return view('user.show-loan', compact('account', 'approvedLoan'));
    }

    public function storeLoan(Request $request)
    {
        $user = Auth::guard('web')->user();
        $recipientAccount = $user->account()->first();

        $request->validate([
            'value' => 'required|numeric',
            'password' => 'required|string|max:255',
        ]);

        if (!(Hash::check($request->password, $user->password))) {
            return redirect()->back()->withErrors(['password' => 'Senha incorreta.']);
        }

        $haveLoan = UserPendencie::where('title', "Empréstimo")->where('recipientAccount', $recipientAccount->number)->where('status', 0)->first();
        $manager = $user->manager()->first();

        if(!empty($haveLoan))
            return redirect()->back()->withErrors(['value' => "Você já tem um empréstimo em aberto, aguarde a aprovação pelo administrador. Os dados para contato do administrador são email: $manager->email e telefone: $manager->phoneNumber"]);

        $value = (double) $request->value;
        $date = Carbon::now()->format('Y-m-d H:i:s');

        UserPendencie::create([
            'title' =>  "Empréstimo",
            'senderAccount' => null,
            'recipientAccount' => $recipientAccount->number,
            'value' => $value,
            'date' => $date,
            'manager' => $manager->id
        ]);

        $request->session()->flash('msg', "Pedido de empréstimo realizado com sucesso! Aguarde a aprovação pelo administrador. Os dados para contato do administrador são email: $manager->email e telefone: $manager->phoneNumber");

        return redirect(route('user-dashboard'));
    }

    public function payLoan(Request $request)
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();
        $approvedLoan = UserPendencie::where('title', "Empréstimo")->where('recipientAccount', $account->number)->where('status', 1)->first();

        $request->validate([
            'password' => 'required|string|max:255',
        ]);

        if($approvedLoan->value > $account->balance)
            return redirect()->back()->withErrors(['value' => 'Saldo insuficiente.']);

        if (!(Hash::check($request->password, $user->password))) {
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

        return redirect(route('user-dashboard'));
    }

    public function showEditProfile()
    {
        $user = Auth::guard('web')->user();
        $account = $user->account()->first();

        return view('user.show-edit-profile', compact('account'));
    }
}
