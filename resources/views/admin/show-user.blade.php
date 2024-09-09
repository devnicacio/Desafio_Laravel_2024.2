<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                {{ __('Painel de Administrador') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Visalização de usuário"}}
                </div>
            </div>
            <div class="py-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex justify-center items-center flex-col">
                    <div for="photo" class="relative rounded-full overflow-hidden mb-4">
                        <img id="photo-preview" src="{{"/" . $user->photo }}" alt="Foto de perfil do Usuário" class="object-cover w-32 h-32">
                    </div>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 w-full">
                        <div class="flex flex-col">
                            <label for="name">Nome</label>
                            <input type="text" id="name" readonly value="{{$user->name}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="email">E-mail</label>
                            <input type="text" id="email" readonly value="{{$user->email}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="country">País</label>
                            <input type="text" id="country" readonly value="{{$address->country}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="postalcode">CEP</label>
                            <input type="text" id="postalcode" readonly value="{{$address->postalCode}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="state">Estado</label>
                            <input type="text" id="state" readonly value="{{$address->state}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="city">Cidade</label>
                            <input type="text" id="city" readonly value="{{$address->city}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="neighborhood">Bairro</label>
                            <input type="text" id="neighborhood" readonly value="{{$address->neighborhood}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="street">Rua</label>
                            <input type="text" id="street" readonly value="{{$address->street}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="number">Número</label>
                            <input type="text" id="number" readonly value="{{$address->number}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="complement">Complemento</label>
                            <input type="text" id="complement" readonly value="{{$address->complement}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="phoneNumber">Telefone</label>
                            <input type="text" id="phoneNumber" readonly value="{{$user->phoneNumber}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="birthdate">Data de nascimento</label>
                            <input type="text" id="birthdate" readonly value="{{$user->birthdate->format('d/m/Y')}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" readonly value="{{$user->cpf}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="transferLimit">Limite de transferência</label>
                            <input type="text" id="transferLimit" readonly value="{{"R$ " . number_format($accountUser->transferLimit, 2, ',', '.')}}" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="manager">Gerente</label>
                            <input type="text" id="manager" readonly value="{{$manager->name}}" class="rounded-md">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>