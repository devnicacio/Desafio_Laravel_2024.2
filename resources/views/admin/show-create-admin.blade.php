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
                    {{"Criar admin"}}
                </div>
            </div>
            <div class="py-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex justify-center items-center flex-col">
                    @if($errors->any())
                        <x-safebank-alert-message>
                            {{$errors->first()}}
                        </x-safebank-alert-message>
                    @endif
                    <form action="{{route('admin-create-admin')}}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                        @csrf
                        <label for="photo" class="relative rounded-full overflow-hidden cursor-pointer">
                            <img id="photo-preview" src="/images/safebank-default-profile-photo.png" class="object-cover w-32 h-32">
                            <input type="file" id="photo" name="photo" class="hidden" accept="image/*" onchange="previewPhoto(event)">
                        </label>
                        <p class="text-gray-500 mb-4">Clique para adicionar uma imagem</p>
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 w-full">
                            <div class="flex flex-col">
                                <label for="name">Nome</label>
                                <input type="text" id="name" name="name" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="country">País</label>
                                <input type="text" id="country" name="country" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="postalCode">CEP</label>
                                <input type="text" id="postalCode" name="postalCode" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="state">Estado</label>
                                <input type="text" id="state" name="state" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="city">Cidade</label>
                                <input type="text" id="city" name="city" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="neighborhood">Bairro</label>
                                <input type="text" id="neighborhood" name="neighborhood" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="street">Rua</label>
                                <input type="text" id="street" name="street" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="number">Número</label>
                                <input type="number" id="number" name="number" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="complement">Complemento</label>
                                <input type="text" id="complement" name="complement" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="phoneNumber">Telefone</label>
                                <input type="text" id="phoneNumber" name="phoneNumber" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="birthdate">Data de nascimento</label>
                                <input type="date" id="birthdate" name="birthdate" class="rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="cpf">CPF</label>
                                <input type="text" id="cpf" name="cpf" class="rounded-md">
                            </div>
                            <div class="flex flex-col mb-6">
                                <label for="password">Senha do usuário</label>
                                <input type="password" id="password" name="password" class="rounded-md">
                            </div>
                        </div>
                        <x-safebank-form-button>
                            {{"Salvar"}}
                        </x-safebank-form-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById('photo-preview');
                img.src = reader.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    </script>
</x-app-layout>