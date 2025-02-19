<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teléfonos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <!-- Combined Card -->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Filtros de Búsqueda y Exportar Datos</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('tels.index') }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <select id="provincia" name="provincia" class="form-control select2"
                                                onchange="updateLocalidades()">
                                            <option value="">Seleccione una provincia</option>
                                            @foreach($provincias as $provincia)
                                                <option
                                                    value="{{ $provincia->id }}" {{ $selectedProvincia == $provincia->id ? 'selected' : '' }}>{{ $provincia->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select id="localidad" name="localidad" class="form-control select2">
                                            <option value="">Seleccione una localidad</option>
                                            @foreach($localidades as $localidad)
                                                <option
                                                    value="{{ $localidad->id }}" {{ $selectedLocalidad == $localidad->id ? 'selected' : '' }}>{{ $localidad->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button type="submit" id="filter-button" class="btn btn-primary">Filtrar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('tels.export') }}" id="export-form" class="mt-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="quantity">Cantidad</label>
                                        <select id="quantity" name="quantity" class="form-control">
                                            @foreach([100, 200, 300, 500, 700, 1000, 2000, 5000, 10000, 20000, 50000, 100000, 200000, 500000, 1000000] as $quantity)
                                                <option value="{{ $quantity }}">{{ $quantity }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="file_name">Nombre del Archivo (opcional):</label>
                                        <input type="text" name="file_name" id="file_name" class="form-control">
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button type="submit" class="btn btn-secondary mt-4">Exportar</button>
                                    </div>
                                    <input type="hidden" id="export-provincia-id" name="provincia_id"
                                           value="{{ $selectedProvincia }}">
                                    <input type="hidden" id="export-localidad-id" name="localidad_id"
                                           value="{{ $selectedLocalidad }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <button onclick="window.location.href='{{ route('tels.create') }}'"
                            class="btn btn-success mb-3">Agregar Teléfono
                    </button>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Persona ID</th>
                            <th>Tipo Teléfono</th>
                            <th>Nro Teléfono</th>
                            <th>Localidad</th>
                            <th>Provincia</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tels as $tel)
                            <tr>
                                <td>{{ $tel->persona_id }}</td>
                                <td>{{ $tel->tipo_telefono }}</td>
                                <td>{{ $tel->nro_telefono }}</td>
                                <td>{{ $tel->localidad->name }}</td>
                                <td>{{ $tel->localidad->provincia->name }}</td>
                                <td>
                                    <a href="{{ route('tels.show', $tel) }}"
                                       class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('tels.edit', $tel) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('tels.destroy', $tel) }}" method="POST"
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button">Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $tels->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: '¿Está seguro?',
                    text: "No podrá deshacer esta elección",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, borrar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        function updateLocalidades() {
            const provinciaId = document.getElementById('provincia').value;
            const localidadSelect = document.getElementById('localidad');
            localidadSelect.innerHTML = '<option value="">Seleccione una localidad</option>';
            if (provinciaId) {
                fetch(`/api/provincias/${provinciaId}/localidades`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(localidad => {
                            const option = document.createElement('option');
                            option.value = localidad.id;
                            option.textContent = localidad.name;
                            localidadSelect.appendChild(option);
                        });
                    });
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true,
                width: '100%'
            });

            function updateExportFields() {
                const selectedProvinciaId = $('#provincia').val();
                const selectedLocalidadId = $('#localidad').val();

                $('#export-provincia-id').val(selectedProvinciaId);
                $('#export-localidad-id').val(selectedLocalidadId);
            }

            $('#provincia').on('change', function () {
                updateExportFields();
                updateLocalidades();
            });

            $('#localidad').on('change', function () {
                updateExportFields();
            });

            // Set initial values for export form fields
            updateExportFields();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const exportForm = document.querySelector('form[action="{{ route('tels.export') }}"]');

            exportForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(exportForm);

                fetch(exportForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Exportación Iniciada',
                            html: `${data.message} <br><a href="{{ route('exports.index') }}">Ver Archivos Exportados</a>`,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                    })
                    .catch(error => {
                        console.error('Error en la exportación:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al iniciar la exportación. Intente nuevamente.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
            });
        });
    </script>
</x-app-layout>
