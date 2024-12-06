<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Analytics Data -->
                    @if($analytics)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Analytics Data</h3>

                            <!-- Table for Analytics Data -->
                            <table class="min-w-full bg-white dark:bg-gray-800">
                                <thead>
                                <tr>
                                    <th class="py-2">Metric</th>
                                    <th class="py-2">Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Total Teléfonos</td>
                                    <td>{{ $analytics->total_telefonos }}</td>
                                </tr>
                                <tr>
                                    <td>Total Usuarios</td>
                                    <td>{{ $analytics->total_usuarios }}</td>
                                </tr>
                                <tr>
                                    <td>Localidad con más Teléfonos</td>
                                    <td>{{ $analytics->localidad_con_mas_telefonos }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Chart for Teléfonos por Provincia -->
                        <div class="mt-6">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Teléfonos por Provincia</h4>
                            <canvas id="telefonosPorProvinciaChart"></canvas>
                        </div>

                        <!-- Chart for Usuarios por Rol -->
                        <div class="mt-6">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Usuarios por Rol</h4>
                            <canvas id="usuariosPorRolChart"></canvas>
                        </div>

                        <!-- Chart for Ranking de Provincias -->
                        <div class="mt-6">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Ranking de Provincias</h4>
                            <canvas id="rankingProvinciasChart"></canvas>
                        </div>
                    @else
                        <p class="mt-6 text-gray-800 dark:text-gray-200">No analytics data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data for Teléfonos por Provincia
        const telefonosPorProvinciaData = {
            labels: {!! json_encode(array_keys($analytics->telefonos_por_provincia)) !!},
            datasets: [{
                label: 'Teléfonos por Provincia',
                data: {!! json_encode(array_values($analytics->telefonos_por_provincia)) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Data for Usuarios por Rol
        const usuariosPorRolData = {
            labels: {!! json_encode(array_keys($analytics->usuarios_por_rol)) !!},
            datasets: [{
                label: 'Usuarios por Rol',
                data: {!! json_encode(array_values($analytics->usuarios_por_rol)) !!},
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        // Data for Ranking de Provincias
        const rankingProvinciasData = {
            labels: {!! json_encode(array_keys($analytics->ranking_provincias)) !!},
            datasets: [{
                label: 'Ranking de Provincias',
                data: {!! json_encode(array_values($analytics->ranking_provincias)) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        };

        // Config for Teléfonos por Provincia Chart
        const telefonosPorProvinciaConfig = {
            type: 'bar',
            data: telefonosPorProvinciaData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Config for Usuarios por Rol Chart
        const usuariosPorRolConfig = {
            type: 'pie',
            data: usuariosPorRolData,
            options: {}
        };

        // Config for Ranking de Provincias Chart
        const rankingProvinciasConfig = {
            type: 'line',
            data: rankingProvinciasData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Render Charts
        new Chart(document.getElementById('telefonosPorProvinciaChart'), telefonosPorProvinciaConfig);
        new Chart(document.getElementById('usuariosPorRolChart'), usuariosPorRolConfig);
        new Chart(document.getElementById('rankingProvinciasChart'), rankingProvinciasConfig);
    </script>
</x-app-layout>
