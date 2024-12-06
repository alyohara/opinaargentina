<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Existing links -->
                </div>

                <!-- Analytics Data -->
                @if($analytics)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Analytics Data</h3>
                        <p>Total Teléfonos: {{ $analytics->total_telefonos }}</p>
                        <p>Total Usuarios: {{ $analytics->total_usuarios }}</p>
                        <p>Localidad con más Teléfonos: {{ $analytics->localidad_con_mas_telefonos }}</p>

                        <h4 class="mt-4 text-md font-semibold text-gray-800 dark:text-gray-200">Teléfonos por Provincia</h4>
                        <ul>
                            @foreach($analytics->telefonos_por_provincia as $provincia => $total)
                                <li>{{ $provincia }}: {{ $total }}</li>
                            @endforeach
                        </ul>

                        <h4 class="mt-4 text-md font-semibold text-gray-800 dark:text-gray-200">Usuarios por Rol</h4>
                        <ul>
                            @foreach($analytics->usuarios_por_rol as $rol => $total)
                                <li>{{ $rol }}: {{ $total }}</li>
                            @endforeach
                        </ul>

                        <h4 class="mt-4 text-md font-semibold text-gray-800 dark:text-gray-200">Ranking de Provincias</h4>
                        <ul>
                            @foreach($analytics->ranking_provincias as $provincia => $total)
                                <li>{{ $provincia }}: {{ $total }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="mt-6 text-gray-800 dark:text-gray-200">No analytics data available.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
