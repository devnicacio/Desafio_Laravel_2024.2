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
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @if(!empty($msg))
                <x-safebank-confirm-message>
                    {{$msg}}
                </x-safebank-confirm-message>
            @endif
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Transferências"}}
                </div>
                <div class="p-6 text-gray-900 text-lg">
                    {{"Saldo: R$ " . number_format($account->balance, 2, ',', '.')}}
                </div>
            </div>
            <div class="py-6">
                <div class="bg-white overflow-hidden rounded-lg grid grid-cols-5 gap-4 mt-4 shadow-sm mb-4">
                    <div class="flex justify-center">
                        <p class="px-6 py-4 text-sm md:text-lg">Título</p>
                    </div>
                    <div class="flex justify-center">
                        <p class="px-6 py-4 text-sm md:text-lg">Remetente</p>
                    </div>
                    <div class="flex justify-center">
                        <p class="px-6 py-4 text-sm md:text-lg">Destinatário</p>
                    </div>
                    <div class="flex justify-center">
                        <p class="px-6 py-4 text-sm md:text-lg">Valor</p>
                    </div>
                    <div class="flex justify-center">
                        <p class="px-6 py-4 text-sm md:text-lg">Data</p>
                    </div>
                </div>
                @if($transfers->count() == 0)
                    <p class="flex justify-center text-xl my-4 text-gray-500">Você ainda não tem transferências</p>
                @endif
                @foreach ($transfers as $transfer)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg grid grid-cols-5 text-center items-center p-4 mb-2">
                    <div class="flex justify-center items-center text-sm md:text-base">
                        <p>{{$transfer->title}}</p>
                    </div>
                    <div class="flex justify-center items-center text-sm md:text-base">
                        @if($transfer->senderAccount == null)
                            <p>-</p>
                        @else
                            <p>{{$transfer->senderAccount}}</p>
                        @endif
                    </div>
                    <div class="flex justify-center items-center text-sm md:text-base">
                        @if($transfer->recipientAccount == null)
                            <p>-</p>
                        @else
                            <p>{{$transfer->recipientAccount}}</p>
                        @endif
                    </div>
                    <div class="flex justify-center items-center text-sm md:text-base">
                        <p>{{"R$ " . number_format($transfer->value, 2, ',', '.')}}</p>
                    </div>
                    <div class="flex justify-center items-center text-sm md:text-base">
                        <p>{{$transfer->date->format('d/m/Y')}}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-center">
                <div class="bg-white overflow-hidden rounded-lg flex flex-col gap-4 mt-4 shadow-sm mb-4 w-[600px] p-6">
                    <p class="text-lg">Imprimir extrato</p>
                    <form action="generatepdf" class="w-full flex flex-col" method="POST">
                        @csrf
                        <label for="month" class="mb-2">Digite o número de meses desejados</label>
                        <input type="text" name="month" id="month" class="rounded-md mb-4">
                        <div class="flex flex-col items-center">
                            <x-safebank-form-button>
                                {{"Imprimir"}}
                            </x-safebank-form-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
