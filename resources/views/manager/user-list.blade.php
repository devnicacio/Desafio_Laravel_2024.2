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
                    <a href="">
                        <x-primary-button style="background:#0571d3">
                            {{"Criar usuário"}}
                        </x-primary-button>
                    </a>
                </div>
            </div>
            <div class="py-6">
                @foreach ($users as $user)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-4 mb-2">
                    <div>
                        <p>{{$user->name}}</p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('manager-show-user', $user->id) }}" style="background:#0571d3; padding:7px 10px; border-radius: 6px">
                            <i class="bi bi-eye-fill" style="font-size:17px; color:white"></i>
                        </a>
                        <a href="{{ route('manager-show-edit', $user->id) }}" style="background:#0571d3; padding:7px 10px; border-radius: 6px">
                            <i class="bi bi-pencil-square" style="font-size:17px; color:white"></i>
                        </a>
                        <a href="" style="background:#0571d3; padding:7px 10px; border-radius: 6px">
                            <i class="bi bi-trash3-fill" style="font-size:17px; color:white"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
