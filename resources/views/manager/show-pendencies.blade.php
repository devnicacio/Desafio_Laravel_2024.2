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
            @if (!empty($msg))
                <x-safebank-confirm-message>
                    {{ $msg }}
                </x-safebank-confirm-message>
            @endif
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{ "Lista de pendências" }}
                </div>
            </div>
            <div class="bg-white overflow-hidden rounded-lg grid grid-cols-4 gap-4 mt-4 shadow-sm">
                <div class="flex justify-center">
                    <p class="px-6 py-4 text-lg">Cliente</p>
                </div>
                <div class="flex justify-center">
                    <p class="px-6 py-4 text-lg">Limite de Transferência</p>
                </div>
                <div class="flex justify-center">
                    <p class="px-6 py-4 text-lg">Valor</p>
                </div>
                <div class="flex justify-center">
                    <p class="px-6 py-4 text-lg">Ações</p>
                </div>
            </div>
            <div>
                @if ($transferPendencies->count() == 0)
                    <p class="flex justify-center text-xl my-4 text-gray-500">Você ainda não têm pendências</p>
                @endif
                @foreach ($transferPendencies as $transferPendencie)
                    @php
                        $senderAccount = \App\Models\Account::where('number', $transferPendencie->senderAccount)->first();
                        $user = \App\Models\User::where('account', $senderAccount->id)->first();
                        $address = $user->address()->first();
                    @endphp
                    <div class="bg-white overflow-hidden rounded-lg grid grid-cols-4 gap-4 mt-4 shadow-sm p-4 mb-2">
                        <div class="flex justify-center items-center">
                            <button onclick="openUserModal('userModal-{{$transferPendencie->id}}')">
                                <p class="text-[#0571d3] hover:text-orange-400 transition-colors">
                                    {{ $user->name }}
                                </p>
                            </button>
                        </div>
                        <div class="flex justify-center items-center">
                            <p>{{ "R$ " . number_format($senderAccount->transferLimit, 2, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-center items-center">
                            <p>{{ "R$ " . number_format($transferPendencie->value, 2, ',', '.') }}</p>
                        </div>
                        <div class="flex gap-2 ml-4 justify-center items-center">
                            <form action="{{route('manager-accept-pendencie', $transferPendencie->id)}}" method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-2 py-1">
                                    <i class="bi bi-check-lg" style="font-size:17px; color:white"></i>
                                </button>
                            </form>

                            <form action="{{route('manager-deny-pendencie', $transferPendencie->id)}}" method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-2 py-1">
                                    <i class="bi bi-x-lg" style="font-size:17px; color:white"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div id="userModal-{{$transferPendencie->id}}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                        <div class="bg-white shadow-sm rounded-lg p-6 flex flex-col w-3/4 h-[90%] overflow-y-auto items-center">
                            <div class="flex flex-col items-center mb-4">
                                <div class="relative rounded-full overflow-hidden">
                                    <img id="photo-preview" src="{{ '/' . $user->photo }}" alt="Foto de perfil do Usuário"
                                        class="object-cover w-32 h-32">
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 w-full">
                                <div class="flex flex-col">
                                    <label for="name">Nome</label>
                                    <input type="text" id="name" readonly value="{{ $user->name }}" class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="email">E-mail</label>
                                    <input type="text" id="email" readonly value="{{ $user->email }}" class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="country">País</label>
                                    <input type="text" id="country" readonly value="{{ $address->country }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="postalcode">CEP</label>
                                    <input type="text" id="postalcode" readonly value="{{ $address->postalCode }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="state">Estado</label>
                                    <input type="text" id="state" readonly value="{{ $address->state }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="city">Cidade</label>
                                    <input type="text" id="city" readonly value="{{ $address->city }}" class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="neighborhood">Bairro</label>
                                    <input type="text" id="neighborhood" readonly value="{{ $address->neighborhood }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="street">Rua</label>
                                    <input type="text" id="street" readonly value="{{ $address->street }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="number">Número</label>
                                    <input type="text" id="number" readonly value="{{ $address->number }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="complement">Complemento</label>
                                    <input type="text" id="complement" readonly value="{{ $address->complement }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="phoneNumber">Telefone</label>
                                    <input type="text" id="phoneNumber" readonly value="{{ $user->phoneNumber }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="birthdate">Data de nascimento</label>
                                    <input type="text" id="birthdate" readonly
                                        value="{{ $user->birthdate->format('d/m/Y') }}" class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="cpf">CPF</label>
                                    <input type="text" id="cpf" readonly value="{{ $user->cpf }}" class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="transferLimit">Limite de transferência</label>
                                    <input type="text" id="transferLimit" readonly
                                        value="{{ 'R$ ' . number_format($senderAccount->transferLimit, 2, ',', '.') }}"
                                        class="rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="manager">Gerente</label>
                                    <input type="text" id="manager" readonly value="{{ $manager->name }}"
                                        class="rounded-md">
                                </div>
                            </div>
                            <button onclick="closeUserModal('userModal-{{$transferPendencie->id}}')" class="bg-red-500 hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-center items-center p-5 w-fit h-fit mt-4">Fechar</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function openUserModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('flex');
        }

        function closeUserModal(modalId) {
            document.getElementById(modalId).classList.remove('flex');
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>
