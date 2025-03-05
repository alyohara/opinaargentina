<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">Edit User</h1>
                <form id="userForm" action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de Usuario:</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email:</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password (leave blank to keep current password):</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" value="{{$user->nombre}}  class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" value="{{$user->apellido}}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" value="{{$user->telefono}}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    <div class="form-group">
                        <label for="role_id">Rol</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            var telefono = document.getElementById('telefono').value;
            var telefonoPattern = /^[0-9]{10}$/;
            if (!telefonoPattern.test(telefono)) {
                alert('Por favor, ingrese un número de teléfono válido.');
                event.preventDefault();
            }
        });
    </script>

</x-app-layout>
