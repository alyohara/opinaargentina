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
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <select id="state" class="form-control">
                                <option value="">Seleccione una provincia</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select id="city" class="form-control">
                                <option value="">Seleccione una ciudad</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button id="filter-button" class="btn btn-primary">Filtrar</button>
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
                        <tbody id="telefonos-table-body">
                        <!-- Data will be populated here -->
                        </tbody>
                    </table>
                    <div id="pagination-links">
                        <!-- Pagination links will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filter-button').addEventListener('click', function () {
            const stateId = document.getElementById('state').value;
            const cityId = document.getElementById('city').value;

            fetch(`/api/telefonos?state_id=${stateId}&city_id=${cityId}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('telefonos-table-body');
                    tableBody.innerHTML = '';

                    data.data.forEach(telefono => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${telefono.telefono}</td>
                            <td>${telefono.movil}</td>
                            <td>${telefono.city.name}</td>
                            <td>${telefono.city.state.name}</td>
                            <td>
                                <a href="/telefonos/${telefono.id}" class="btn btn-info btn-sm">Ver</a>
                                <a href="/telefonos/${telefono.id}/edit" class="btn btn-warning btn-sm">Editar</a>
                                <form action="/telefonos/${telefono.id}" method="POST" class="d-inline delete-form">
                                    @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-button">Eliminar</button>
                    </form>
                </td>
`;
                        tableBody.appendChild(row);
                    });

                    const paginationLinks = document.getElementById('pagination-links');
                    paginationLinks.innerHTML = data.links;
                });
        });
    </script>
</x-app-layout>
