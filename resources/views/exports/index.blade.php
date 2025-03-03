<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Archivos Exportados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tamaño (KB)</th>
                            <th>Comienzo Exportación</th>
                            <th>Fin Exportación</th>
                            <th>Status</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exports as $export)
                            <tr>
                                <td>{{ $export->id }}</td>
                                <td><a href="{{ str_replace('/storage/storage/', 'storage/', $export->file_path) }}"
                                       target="_blank">{{ str_replace('/storage/', '', $export->file_path) }}</a>
                                </td>
                                <td>{{ $export->file_size }}</td>
                                <td>{{ $export->job_started_at }}</td>
                                <td>{{ $export->job_ended_at }}</td>
                                <td>{{ $export->status }}</td>
                                <td>{{ $export->user->name }}</td>
                                <td>
                                    <a href="{{ Storage::url($export->file_path) }}" class="btn btn-primary"
                                       target="_blank">Download</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $exports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
