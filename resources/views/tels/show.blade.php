<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Teléfono') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="persona_id" class="form-label">Persona ID</label>
                        <input type="text" class="form-control" id="persona_id" value="{{ $tel->persona_id }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_telefono" class="form-label">Tipo Teléfono</label>
                        <input type="text" class="form-control" id="tipo_telefono" value="{{ $tel->tipo_telefono }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nro_telefono" class="form-label">Nro Teléfono</label>
                        <input type="text" class="form-control" id="nro_telefono" value="{{ $tel->nro_telefono }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="localidad_id" class="form-label">Localidad ID</label>
                        <input type="text" class="form-control" id="localidad_id" value="{{ $tel->localidad_id }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="provincia_id" class="form-label">Provincia ID</label>
                        <input type="text" class="form-control" id="provincia_id" value="{{ $tel->provincia_id }}" readonly>
                    </div>
                    <a href="{{ route('tels.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
