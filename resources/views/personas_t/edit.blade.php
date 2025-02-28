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
                    <form action="{{ route('personas_t.update', $personaT->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h3 class="mb-4">Datos Generales</h3>
                        @include('personas_t.form')
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ isset($personaT) ? $personaT->state : old('state') }}">
                            @error('state')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <h3 class="mb-4">Datos Electorales</h3>
                        <div class="mb-3">
                            <label for="seccion" class="form-label">Sección</label>
                            <input type="text" class="form-control" id="seccion" name="seccion" value="{{ isset($personaT) ? $personaT->seccion : old('seccion') }}">
                            @error('seccion')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="circuito" class="form-label">Circuito</label>
                            <input type="text" class="form-control" id="circuito" name="circuito" value="{{ isset($personaT) ? $personaT->circuito : old('circuito') }}">
                            @error('circuito')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mesa" class="form-label">Mesa</label>
                            <input type="number" class="form-control" id="mesa" name="mesa" value="{{ isset($personaT) ? $personaT->mesa : old('mesa') }}">
                            @error('mesa')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="orden" class="form-label">Orden</label>
                            <input type="number" class="form-control" id="orden" name="orden" value="{{ isset($personaT) ? $personaT->orden : old('orden') }}">
                            @error('orden')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="establecimiento" class="form-label">Establecimiento</label>
                            <input type="text" class="form-control" id="establecimiento" name="establecimiento" value="{{ isset($personaT) ? $personaT->establecimiento : old('establecimiento') }}">
                            @error('establecimiento')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion_establecimiento" class="form-label">Dirección del Establecimiento</label>
                            <input type="text" class="form-control" id="direccion_establecimiento" name="direccion_establecimiento" value="{{ isset($personaT) ? $personaT->direccion_establecimiento : old('direccion_establecimiento') }}">
                            @error('direccion_establecimiento')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('personas_t.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinciaSelect = document.getElementById('provincia');
            const localidadSelect = document.getElementById('localidad');
            const selectedProvincia = {{ isset($personaT) && $personaT->localidad && $personaT->localidad->provincia ? $personaT->localidad->provincia->id : 'null' }};
            const selectedLocalidad = {{ isset($personaT) ? $personaT->localidad_id : 'null' }};

            // Función para actualizar las localidades cuando se selecciona una provincia
            function updateLocalidades() {
                const provinciaId = provinciaSelect.value;
                localidadSelect.innerHTML = '<option value="">Seleccione una localidad</option>';
                if (provinciaId) {
                    fetch(`/api/provincias/${provinciaId}/localidades`)
                        .then(response => response.json())
                        .then(localidades => {
                            if (Array.isArray(localidades)) {
                                localidades.forEach(localidad => {
                                    const option = document.createElement('option');
                                    option.value = localidad.id;
                                    option.text = localidad.nombre;
                                    localidadSelect.appendChild(option);
                                });
                            } else {
                                console.error('Error: La respuesta de la API no es un array:', localidades);
                            }
                        });
                }
                // Establecer la localidad seleccionada después de cargar las opciones
                if (selectedLocalidad !== null) {
                    localidadSelect.value = selectedLocalidad;
                }
            }
            // Actualizar las localidades al cargar la página si ya hay una provincia seleccionada
            if (selectedProvincia !== null) {
                provinciaSelect.value = selectedProvincia;
                updateLocalidades();
            }

            // Asignar el evento change al select de provincias
            provinciaSelect.addEventListener('change', updateLocalidades);

        });
    </script>
</x-app-layout>
