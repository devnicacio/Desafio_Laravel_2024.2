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
                    {{ "Enviar e-mail" }}
                </div>
            </div>
            <div class="py-6 flex justify-center">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex justify-center items-center flex-col w-[500px]">
                    @if($errors->any())
                        <x-safebank-alert-message>
                            {{ $errors->first() }}
                        </x-safebank-alert-message>
                    @endif
                    <div class="flex flex-col w-full">
                        <form id="withdraw" action="{{ route('admin-send-email') }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                            @csrf
                            @method('POST')
                            <h2>Quem vai receber o e-mail?</h2>
                            <div class="flex flex-col w-full mb-4">
                                <label for="admin" class="mb-2">Administrador: </label>
                                <input type="checkbox" id="admin" name="admin" class="rounded-md" step="0.01">
                            </div>
                            <div class="flex flex-col w-full mb-4">
                                <label for="manager" class="mb-2">Gerente: </label>
                                <input type="checkbox" id="manager" name="manager" class="rounded-md" step="0.01">
                            </div>
                            <div class="flex flex-col w-full mb-4">
                                <label for="user" class="mb-2">Usuário: </label>
                                <input type="checkbox" id="user" name="user" class="rounded-md" step="0.01">
                            </div>
                            <div class="flex flex-col w-full mb-4">
                                <label for="subject" class="mb-2">Assunto</label>
                                <input type="text" id="subject" name="subject" class="rounded-md">
                            </div>
                            <div class="flex flex-col w-full mb-4">
                                <label for="message" class="mb-2">Mensagem</label>
                                <input type="text" id="message" name="message" class="rounded-md">
                            </div>
                            <button type="sumbit" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
                                Enviar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>