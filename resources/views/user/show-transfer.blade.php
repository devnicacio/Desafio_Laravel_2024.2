<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                {{ __('Painel de Cliente') }}
            </h2>
            <div>
                <p class="text-sm">{{"Agência: $account->agency"}}</p>
                <p class="text-sm">{{"Conta: $account->number"}}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Transferência"}}
                </div>
                <div class="p-6">
                    <p class="text-sm">{{"Saldo: R$ " . number_format($account->balance, 2, ',', '.')}}</p>
                    <p class="text-sm">{{"Limite de transferência: R$ " . number_format($account->transferLimit, 2, ',', '.')}}</p>
                </div>
            </div>
            <div class="py-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex justify-center items-center flex-col">
                    @if($errors->any())
                        <x-safebank-alert-message>
                            {{$errors->first()}}
                        </x-safebank-alert-message>
                    @endif
                    <form id="deposit" action="{{route('user-store-transfer')}}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 w-full mb-4">
                            <div class="flex flex-col">
                                <label for="agency">Agência</label>
                                <input type="number" id="agency" name="agency" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="number">Número da conta</label>
                                <input type="number" id="number" name="number" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="value">Valor do depósito</label>
                                <input type="number" id="value" name="value" class="rounded-md" step="0.01">
                            </div>
                            <div class="flex flex-col">
                                <label for="password">Senha</label>
                                <input type="password" id="password" name="password" class="rounded-md">
                            </div>
                        </div>
                        <button type="button" onclick="openModal()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                            Transferir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-80">
            <h2 class="text-lg font-semibold mb-4">Confirmação de Depósito</h2>
            <p class="mb-4">Deseja transferir o valor informado?</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeModal()" class="bg-red-500 hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                    Cancelar
                </button>
                <button onclick="submitForm()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                    Transferir
                </button>
            </div>
        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }

        function submitForm() {
            document.getElementById('deposit').submit();
        }
    </script>
</x-app-layout>