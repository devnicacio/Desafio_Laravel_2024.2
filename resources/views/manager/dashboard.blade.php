<x-app-layout>
    <x-slot name="header">
        <x-safebank-nav :authguard="Auth::guard('manager')->user()" >
            Painel de Gerente
        </x-safebank-nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @if(!empty($msg))
            <x-safebank-confirm-message>
                {{$msg}}
            </x-safebank-confirm-message>
            @endif
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Saldo: R$ " . number_format($account->balance, 2, ',', '.')}}
                </div>
                <div class="px-6">
                    <x-safebank-link-button route="manager-user-list">
                        {{"Ver extrato"}}
                    </x-safebank-link-button>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 py-6">
                <x-safebank-link-button route="manager-show-withdraw">
                    <p>Saque</p>
                    <i class="bi bi-cash-stack" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-show-deposit">
                    <p>Depósito</p>
                    <i class="bi bi-piggy-bank-fill" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-user-list">
                    <p>Transferência</p>
                    <i class="bi bi-arrow-left-right" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-user-list">
                    <p>Pedir empréstimo</p>
                    <i class="bi bi-cash-coin" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-user-list" icon="cash-stack">
                    <p>Usuários</p>
                    <i class="bi bi-people-fill" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-user-list">
                    <p>Pendências</p>
                    <i class="bi bi-person-fill-exclamation" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-user-list">
                    <p>Empréstimos</p>
                    <i class="bi bi-list-ul" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>
            </div>
        </div>
        
    </div>
</x-app-layout>
