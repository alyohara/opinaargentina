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
            let currentPage = 1;
            let totalPages = 1;

            function updateLocalidades() {
                const provinciaId = document.getElementById('provincia').value;
                const localidadSelect = document.getElementById('localidad');
                localidadSelect.innerHTML = '<option value="">Seleccione una localidad</option>';
                currentPage = 1;
                totalPages = 1;
                if (provinciaId) {
                    fetchLocalidades(provinciaId, currentPage);
                }
            }

            function fetchLocalidades(provinciaId, page) {
                fetch(`/api/provincias/${provinciaId}/localidades?page=${page}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Network response was not ok: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        totalPages = data.last_page;
                        data.data.forEach(localidad => {
                            const option = document.createElement('option');
                            option.value = localidad.id;
                            option.textContent = localidad.nombre;
                            document.getElementById('localidad').appendChild(option);
                        });
                        if (currentPage < totalPages) {
                            currentPage++;
                            fetchLocalidades(provinciaId, currentPage);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching localidades:', error);
                        alert('Error fetching localidades. Please try again later.');
                    });
            }
            // Actualizar las localidades al cargar la página si ya hay una provincia seleccionada
            if (selectedProvincia !== null) {
                provinciaSelect.value = selectedProvincia;
                updateLocalidades();
            }

            // Asignar el evento change al select de provincias
            provinciaSelect.addEventListener('change', updateLocalidades);

        });

        // add select2
        $(document).ready(function() {
            $('.select2').select2();
        });
        

    </script>
</x-app-layout>
