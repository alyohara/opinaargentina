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
                    <a href="{{ route('profile.show') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Profile') }}</span>
                    </a>
                    <a href="{{ route('telefonos.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h1M3 6h1M3 14h1M3 18h1M7 10h1M7 6h1M7 14h1M7 18h1M11 10h1M11 6h1M11 14h1M11 18h1M15 10h1M15 6h1M15 14h1M15 18h1M19 10h1M19 6h1M19 14h1M19 18h1" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Administrar Teléfonos') }}</span>
                    </a>
                    <a href="{{ route('exports.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Archivos Exportados') }}</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Usuarios') }}</span>
                    </a>
                    <a href="{{ route('roles.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Roles') }}</span>
                    </a>
                    <a href="{{ route('permissions.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M12 9v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Permisos') }}</span>
                    </a>
                    <a href="{{ route('equipos.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Equipos') }}</span>
                    </a>
                    <a href="{{ route('states.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Provincias') }}</span>
                    </a>
                    <a href="{{ route('cities.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Ciudades') }}</span>
                    </a>
                    <a href="{{ route('people.index') }}" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 me-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Personas') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
