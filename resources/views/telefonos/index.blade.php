<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teléfonos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <button onclick="window.location.href='{{ route('telefonos.create') }}'" class="btn btn-success mb-3">Agregar Teléfono</button>

                    <!-- Card de Filtros -->
                    <div class="card mb-3">
                        <div class="card-header" data-toggle="collapse" data-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                            <h5 class="mb-0">Filtros de Búsqueda</h5>
                        </div>
                        <div id="filterCard" class="collapse">
                            <div class="card-body">
                                <form method="GET" action="{{ route('telefonos.index') }}">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select id="state" name="state" class="form-control select2" onchange="updateCities()">
                                                <option value="">Seleccione una provincia</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" {{ $selectedState == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select id="city" name="city" class="form-control select2">
                                                <option value="">Seleccione una ciudad</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
{{--                                    <div class="row mt-3">--}}
{{--                                        <div class="col-md-5">--}}
{{--                                            <label>Ordenar por:</label>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="radio" name="order_by" id="orderByCityAsc" value="city_asc">--}}
{{--                                                <label class="form-check-label" for="orderByCityAsc">Ciudad Ascendente</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="radio" name="order_by" id="orderByCityDesc" value="city_desc">--}}
{{--                                                <label class="form-check-label" for="orderByCityDesc">Ciudad Descendente</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="radio" name="order_by" id="orderByStateAsc" value="state_asc">--}}
{{--                                                <label class="form-check-label" for="orderByStateAsc">Provincia Ascendente</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="radio" name="order_by" id="orderByStateDesc" value="state_desc">--}}
{{--                                                <label class="form-check-label" for="orderByStateDesc">Provincia Descendente</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-2 text-right">--}}
{{--                                            <button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </form>
                            </div>
                        </div>
                    </div>

                            <!-- Card de Exportar -->
                    <div class="card mb-3">
                        <div class="card-header" data-toggle="collapse" data-target="#exportCard" aria-expanded="false" aria-controls="exportCard">
                            <h5 class="mb-0">Exportar Datos</h5>
                        </div>
                        <div id="exportCard" class="collapse">
                            <div class="card-body">
                                <form method="POST" action="{{ route('telefonos.export') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="selected-state">Provincia Seleccionada</label>
                                            <input type="text" id="selected-state" name="selected_state" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="selected-city">Ciudad Seleccionada</label>
                                            <input type="text" id="selected-city" name="selected_city" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="quantity">Cantidad</label>
                                            <select id="quantity" name="quantity" class="form-control">
                                                @foreach([100, 200, 300, 500, 700, 1000, 2000, 5000, 10000, 20000, 50000, 100000, 200000, 500000, 1000000] as $quantity)
                                                    <option value="{{ $quantity }}">{{ $quantity }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-secondary">Exportar</button>
                                        </div>
                                    </div>
                                    <!-- Hidden fields to store the selected state and city IDs -->
                                    <input type="hidden" id="export-state-id" name="state_id" value="{{ $selectedState }}">
                                    <input type="hidden" id="export-city-id" name="city_id" value="{{ $selectedCity }}">
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Teléfono</th>
                            <th>Móvil</th>
                            <th>Ciudad</th>
                            <th>Provincia</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($telefonos as $telefono)
                            <tr>
                                <td>{{ $telefono->telefono }}</td>
                                <td>{{ $telefono->movil }}</td>
                                <td>{{ $telefono->city->name }}</td>
                                <td>{{ $telefono->city->state->name }}</td>
                                <td>
                                    <a href="{{ route('telefonos.show', $telefono) }}" class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('telefonos.edit', $telefono) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('telefonos.destroy', $telefono) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $telefonos->links() }}
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

        function updateCities() {
            const stateId = document.getElementById('state').value;
            const citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
            if (stateId) {
                fetch(`/api/states/${stateId}/cities`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    });
            }
        }

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true,
                width: '100%'
            });

            function updateExportFields() {
                const selectedState = $('#state option:selected').text() || 'Sin selección';
                const selectedCity = $('#city option:selected').text() || 'Sin selección';
                const selectedStateId = $('#state').val();
                const selectedCityId = $('#city').val();

                $('#selected-state').val(selectedState);
                $('#selected-city').val(selectedCity);
                $('#export-state-id').val(selectedStateId);
                $('#export-city-id').val(selectedCityId);
            }

            $('#state').on('change', function() {
                updateExportFields();
                updateCities();
            });

            $('#city').on('change', function() {
                updateExportFields();
            });

            // Set initial values for export form fields
            updateExportFields();
        });
    </script>
</x-app-layout>
