<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Persona') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('personas_t.update', $personaT) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @include('personas_t.form')

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('personas_t.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
