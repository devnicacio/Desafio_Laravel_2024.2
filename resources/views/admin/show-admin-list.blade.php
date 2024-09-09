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
            @if(!empty($msg))
                <x-safebank-confirm-message>
                    {{$msg}}
                </x-safebank-confirm-message>
            @endif
            <div class="bg-white overflow-hidden shadow-md rounded-lg flex justify-between items-center">
                <div class="p-6 text-gray-900 text-lg">
                    {{"Lista de admins"}}
                </div>
                <div class="px-6">
                    <a href="">
                        <x-safebank-link-button route="admin-show-create-user">
                            {{"Criar usuário"}}
                        </x-safebank-link-button>
                    </a>
                </div>
            </div>
            <div class="py-6">
                @if($users->count() == 0)
                    <p class="flex justify-center text-xl my-4 text-gray-500">Você ainda não têm usuários cadastrados</p>
                @endif
                @foreach ($users as $user)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg flex justify-between items-center p-4 mb-2">
                    <div>
                        <p>{{$user->name}}</p>
                    </div>
                    @if($user->id != $creator)
                    <div class="flex gap-2 ml-4">
                        <x-safebank-id-link-button route="admin-show-user" id="{{$user->id}}">
                            <i class="bi bi-eye-fill" style="font-size:17px; color:white"></i>
                        </x-safebank-id-link-button>

                        <x-safebank-id-link-button route="admin-show-edit-user" id="{{$user->id}}">
                            <i class="bi bi-pencil-square" style="font-size:17px; color:white"></i>
                        </x-safebank-id-link-button>

                        <button onclick="openDeleteModal({{$user->id}})" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[18px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-2 py-1">
                            <i class="bi bi-trash3-fill" style="font-size:17px; color:white"></i>
                        </button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="deleteUser" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-4 w-[380px]">
            <h1 class="text-lg font-semibold mb-4">Deseja excluir o usuário?</h2>
            <div class="flex flex-col justify-center">
                <div class="flex justify-center w-full mt-2 mb-4">
                    <img src="/images/safebank-delete-image.jpg" class="w-[180px]" alt="">
                </div>
                <div class="flex justify-center gap-4 mt-4">
                    <button onclick="closeDeleteModal()" class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">Cancelar</button>
                    <form action="#" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-orange-400 transition-colors text-white text-[17px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(userId) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin-delete-user/${userId}`;
            document.getElementById('deleteUser').classList.remove('hidden');
            document.getElementById('deleteUser').classList.add('flex');
        }
    
        function closeDeleteModal() {
            document.getElementById('deleteUser').classList.add('hidden');
            document.getElementById('deleteUser').classList.remove('flex');
        }
    </script>
</x-app-layout>
