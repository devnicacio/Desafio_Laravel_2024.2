<x-app-layout>
    <x-slot name="header">
        <x-safebank-admin-nav :authguard="Auth::guard('admin')->user()" >
            Painel de Admin
        </x-safebank-admin-nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @if(!empty($msg))
            <x-safebank-confirm-message>
                {{$msg}}
            </x-safebank-confirm-message>
            @endif
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 py-6">
                <x-safebank-link-button route="admin-show-user-list" icon="cash-stack">
                    <p>Usuários</p>
                    <i class="bi bi-people-fill" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="admin-show-manager-list" icon="cash-stack">
                    <p>Gerentes</p>
                    <i class="bi bi-people-fill" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-user-list" icon="cash-stack">
                    <p>Admins</p>
                    <i class="bi bi-people-fill" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-show-pendencies">
                    <p>Pendências</p>
                    <i class="bi bi-person-fill-exclamation" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>

                <x-safebank-link-button route="manager-show-loans">
                    <p>Empréstimos</p>
                    <i class="bi bi-list-ul" style="font-size:35px; color:white"></i>
                </x-safebank-link-button>
            </div>
        </div>
        
    </div>
</x-app-layout>
