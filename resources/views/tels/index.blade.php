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
                                        <select id="provincia" name="provincia" class="form-control select2" onchange="updateLocalidades()">
                                            <option value="">Seleccione una provincia</option>
                                            @foreach($provincias as $provincia)
                                                <option value="{{ $provincia->id }}" {{ $selectedProvincia == $provincia->id ? 'selected' : '' }}>
                                                    {{ $provincia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="localidad" name="localidad" class="form-control select2">
                                            <option value="">Seleccione una localidad</option>
                                            @if($selectedProvincia)
                                                @foreach($localidades as $localidad)
                                                    <option value="{{ $localidad->id }}" {{ $selectedLocalidad == $localidad->id ? 'selected' : '' }}>
                                                        {{ $localidad->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <select id="tipo_telefono" name="tipo_telefono" class="form-control select2">
                                            <option value="">Seleccione un tipo de teléfono</option>
                                            <option value="fijo" {{ request('tipo_telefono') == 'fijo' ? 'selected' : '' }}>Fijo</option>
                                            <option value="movil" {{ request('tipo_telefono') == 'movil' ? 'selected' : '' }}>Móvil</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select id="order_by" name="order_by" class="form-control select2">
                                            <option value="">Ordenar por</option>
                                            <option value="city_asc" {{ request('order_by') == 'city_asc' ? 'selected' : '' }}>Localidad Ascendente</option>
                                            <option value="city_desc" {{ request('order_by') == 'city_desc' ? 'selected' : '' }}>Localidad Descendente</option>
                                            <option value="state_asc" {{ request('order_by') == 'state_asc' ? 'selected' : '' }}>Provincia Ascendente</option>
                                            <option value="state_desc" {{ request('order_by') == 'state_desc' ? 'selected' : '' }}>Provincia Descendente</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>
                                    </div>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('telefonos.export') }}" id="export-form" class="mt-3">
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
                                    <input type="hidden" id="export-tipo-telefono" name="tipo_telefono"
                                           value="{{ request('tipo_telefono') }}">
                                    <input type="hidden" id="export-order-by" name="order_by"
                                           value="{{ request('order_by') }}">



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
                                <td>{{ $tel->localidad->nombre }}</td>
                                <td>{{ $tel->localidad->provincia->nombre }}</td>
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

        $(document).ready(function () {
            $('.select2').select2({
                // placeholder: 'Seleccione una opción',
                allowClear: true,
                width: '100%'
            });
            //every select2 has a clear button
            $('.select2-selection__clear').on('click', function () {
                $(this).closest('.select2-container').prev('select').val(null).trigger('change');
            });

            $('#provincia').on('select2:open', function (e) {
                $('.select2-search__field').attr('placeholder', 'Seleccione una provincia');
            });
            $('#localidad').on('select2:open', function (e) {
                $('.select2-search__field').attr('placeholder', 'Seleccione una localidad');
            });
            $('#tipo_telefono').on('select2:open', function (e) {
                $('.select2-search__field').attr('placeholder', 'Seleccione un tipo de teléfono');
            });
            $('#order_by').on('select2:open', function (e) {
                $('.select2-search__field').attr('placeholder', 'Seleccione un orden');
            });

            function updateExportFields() {
                const selectedProvinciaId = $('#provincia').val();
                const selectedLocalidadId = $('#localidad').val();
                const selectedTipoTelefono = $('#tipo_telefono').val();
                const selectedOrderBy = $('#order_by').val();

                $('#export-provincia-id').val(selectedProvinciaId);
                $('#export-localidad-id').val(selectedLocalidadId);
                $('#export-tipo-telefono').val(selectedTipoTelefono);
                $('#export-order-by').val(selectedOrderBy);
            }

            $('#provincia').on('change', function () {
                updateExportFields();
                updateLocalidades();
            });

            $('#localidad').on('change', function () {
                updateExportFields();
            });

            $('#tipo_telefono').on('change', function () {
                updateExportFields();
            });

            $('#order_by').on('change', function () {
                updateExportFields();
            });

            // Set initial values for export form fields
            updateExportFields();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const exportForm = document.querySelector('form[action="{{ route('telefonos.export') }}"]');

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
