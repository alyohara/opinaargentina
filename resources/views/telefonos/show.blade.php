<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Teléfono') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" value="{{ $telefono->telefono }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="movil" class="form-label">Móvil</label>
                        <input type="text" class="form-control" id="movil" value="{{ $telefono->movil }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="city" value="{{ $telefono->city->name }}" readonly>
                    </div>
                    <a href="{{ route('telefonos.index') }}" class="btn btn-primary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
