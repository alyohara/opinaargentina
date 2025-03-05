<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <input type="text" name="q" placeholder="Buscar..." class="border rounded px-3 py-2">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
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

                        <!-- Card for Teléfonos por Provincia -->
                        <div class="mt-6 bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Teléfonos por Provincia</h4>
                            <canvas id="telefonosPorProvinciaChart"></canvas>
                        </div>
                    @else
                        <p class="mt-6 text-gray-800 dark:text-gray-200">No analytics data available.</p>
                    @endif
                </div>
                <!-- Card for Ranking de Provincias -->
                @if($analytics)
                    <div class="mt-12 bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Ranking de Provincias</h4>
                        <canvas id="rankingProvinciasChart"></canvas>
                    </div>
                @endif
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

        // Config for Teléfonos por Provincia Chart
        const telefonosPorProvinciaConfig = {
            type: 'bar',
            data: telefonosPorProvinciaData,
            options: {
                onClick: (e, item) => {
                    if (item.length > 0) {
                        const provincia = item[0].index;
                        const provinciaId = telefonosPorProvinciaData.labels[provincia];
                        window.location.href = `/telefonos/provincia/${provinciaId}`;
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
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

        // Config for Ranking de Provincias Chart
        const rankingProvinciasConfig = {
            type: 'line',
            data: rankingProvinciasData,
            options: {
                onClick: (e, item) => {
                    if (item.length > 0) {
                        const provincia = item[0].index;
                        const provinciaId = rankingProvinciasData.labels[provincia];
                        fetch(`/telefonos/provincia/${provinciaId}/ciudades`)
                            .then(response => response.json())
                            .then(data => {
                                updateRankingChart(data);
                            });
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Function to update the ranking chart with new data
        function updateRankingChart(data) {
            rankingProvinciasChart.data.labels = Object.keys(data);
            rankingProvinciasChart.data.datasets[0].data = Object.values(data);
            rankingProvinciasChart.update();
        }

        // Render Charts
        new Chart(document.getElementById('telefonosPorProvinciaChart'), telefonosPorProvinciaConfig);
        const rankingProvinciasChart = new Chart(document.getElementById('rankingProvinciasChart'), rankingProvinciasConfig);

    </script>
</x-app-layout>
