<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                {{ __('Gerente') }}
            </h2>
            <div>
                <p class="text-sm">Agência: </p>
                <p class="text-sm">Conta: </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{ __("Saldo: R$") }}
                </div>
                <div class="px-6">
                    <x-primary-button>
                        {{"Ver extrato"}}
                    </x-primary-button>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 py-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Alalao</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Alalao</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Alalao</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Alalao</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Alalao</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center p-6">
                    <p>Alalao</p>
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>
