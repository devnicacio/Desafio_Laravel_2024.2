<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                {{ __('Painel de Gerente') }}
            </h2>
            <div>
                <p class="text-sm">{{ "Agência: $account->agency" }}</p>
                <p class="text-sm">{{ "Conta: $account->number" }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{ "Pedir empréstimo" }}
                </div>
                <div>
                    <h1 class="text-[13px] md:text-[15px] lg:text-[18px] px-6">Seu saldo: R$ {{ number_format($account->balance, 2, ',', '.') }}</h1>
                </div>
            </div>
            <div class="py-6 flex justify-center">
                @if(empty($approvedLoan))
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex justify-center items-center flex-col w-[500px]">
                    @if($errors->any())
                        <x-safebank-alert-message>
                            {{ $errors->first() }}
                        </x-safebank-alert-message>
                    @endif
                    <div class="flex flex-col w-full">
                        <form id="storeloan" action="{{ route('manager-store-loan') }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                            @csrf
                            @method('POST')
                            <div class="flex flex-col w-full mb-4">
                                <label for="value" class="mb-2">Digite o valor do empréstimo</label>
                                <input type="number" id="value" name="value" class="rounded-md" step="0.01">
                            </div>
                            <div class="flex flex-col w-full mb-4">
                                <label for="password" class="mb-2">Digite sua senha</label>
                                <input type="password" id="password" name="password" class="rounded-md">
                            </div>
                            <button type="button" onclick="openModalStore()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                                Pedir
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex justify-center items-center flex-col w-[500px]">
                    @if($errors->any())
                        <x-safebank-alert-message>
                            {{ $errors->first() }}
                        </x-safebank-alert-message>
                    @endif
                    <div class="flex flex-col w-full">
                        <form id="payloan" action="{{ route('manager-pay-loan') }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                            @csrf
                            @method('POST')
                            <div class="flex items-start mb-6">
                                <p class="text-lg">Você tem um empréstimo de {{"R$ " . number_format($approvedLoan->value, 2, ',', '.')}} a pagar.</p>
                            </div>
                            <div class="flex flex-col w-full mb-6">
                                <label for="password" class="mb-2">Digite sua senha</label>
                                <input type="password" id="password" name="password" class="rounded-md">
                            </div>
                            <button type="button" onclick="openModalPay()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                                Pagar
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="modalStoreLoan" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-80">
            <h2 class="text-lg font-semibold mb-4">Confirmação de Empréstimo</h2>
            <p class="mb-4">Deseja pedir um empréstimo no valor informado?</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeModalStore()" class="bg-red-500 hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                    Cancelar
                </button>
                <button onclick="submitFormStore()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                    Pedir
                </button>
            </div>
        </div>
    </div>

    <div id="modalPayLoan" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-80">
            <h2 class="text-lg font-semibold mb-4">Confirmação de Pagamento</h2>
            <p class="mb-4">Deseja pagar o empréstimo?</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeModalPay()" class="bg-red-500 hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                    Cancelar
                </button>
                <button onclick="submitFormPay()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                    Pagar
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModalStore() {
            document.getElementById('modalStoreLoan').classList.remove('hidden');
            document.getElementById('modalStoreLoan').classList.add('flex');
        }

        function closeModalStore() {
            document.getElementById('modalStoreLoan').classList.add('hidden');
            document.getElementById('modalStoreLoan').classList.remove('flex');
        }

        function submitFormStore() {
            document.getElementById('storeloan').submit();
        }

        function openModalPay() {
            document.getElementById('modalPayLoan').classList.remove('hidden');
            document.getElementById('modalPayLoan').classList.add('flex');
        }

        function closeModalPay() {
            document.getElementById('modalPayLoan').classList.add('hidden');
            document.getElementById('modalPayLoan').classList.remove('flex');
        }

        function submitFormPay() {
            document.getElementById('payloan').submit();
        }
    </script>
</x-app-layout>