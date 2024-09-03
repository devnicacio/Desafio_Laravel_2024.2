<x-app-layout>
    <x-slot name="header">
        <x-safebank-nav :authguard="Auth::guard('manager')->user()" >
            Painel Gerente
        </x-safebank-nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Saldo: R$ $account->balance"}}
                </div>
                <div class="px-6">
                    <x-primary-button style="background:#0571d3">
                        {{"Ver extrato"}}
                    </x-primary-button>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 py-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Saque</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Depósito</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Transferência</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Empréstimo</p>
                </div>
                <a href="/manager-user-list">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                        <p>Lista de usuários</p>
                    </div>
                </a>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Pendências</p>
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>
