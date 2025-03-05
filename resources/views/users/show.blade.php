<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3>{{ $user->name }}</h3>
                    <p>Nombre: {{ $user->nombre }}</p>
                    <p>Apellido: {{ $user->apellido }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Teléfono: {{ $user->telefono }}</p>

                    <a href="{{ route('users.index') }}" class="btn btn-primary">Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
