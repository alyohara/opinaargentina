<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Teléfono') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('tels.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="persona_id" class="form-label">Persona ID</label>
                            <input type="number" class="form-control" id="persona_id" name="persona_id">
                        </div>
                        <div class="mb-3">
                            <label for="tipo_telefono" class="form-label">Tipo Teléfono</label>
                            <select class="form-control" id="tipo_telefono" name="tipo_telefono">
                                <option value="fijo">Fijo</option>
                                <option value="movil">Móvil</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nro_telefono" class="form-label">Nro Teléfono</label>
                            <input type="text" class="form-control" id="nro_telefono" name="nro_telefono">
                        </div>
                        <div class="mb-3">
                            <label for="localidad_id" class="form-label">Localidad ID</label>
                            <input type="number" class="form-control" id="localidad_id" name="localidad_id">
                        </div>
                        <div class="mb-3">
                            <label for="provincia_id" class="form-label">Provincia ID</label>
                            <input type="number" class="form-control" id="provincia_id" name="provincia_id">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
