<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                {{ __('Painel de Gerente') }}
            </h2>
            <div>
                <p class="text-sm">{{"Agência: $account->agency"}}</p>
                <p class="text-sm">{{"Conta: $account->number"}}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Lista de usuários"}}
                </div>
                <div class="px-6">
                    <x-primary-button style="background:#0571d3">
                        {{"Criar usuário"}}
                    </x-primary-button>
                </div>
            </div>
            <div class="py-6">
                @foreach ($users as $user)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-4 mb-2">
                    <div>
                        <p>{{$user->name}}</p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <x-primary-button style="background:#0571d3; padding:7px 10px">
                            <i class="bi bi-eye-fill" style="font-size:17px"></i>
                        </x-primary-button>
                        <x-primary-button style="background:#ffa500; padding:7px 10px">
                            <i class="bi bi-pencil-square" style="font-size:17px"></i>
                        </x-primary-button>
                        <x-primary-button style="background:red; padding:7px 10px">
                            <i class="bi bi-trash3-fill" style="font-size:17px"></i>
                        </x-primary-button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
