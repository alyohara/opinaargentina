<!-- resources/views/equipos/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <button onclick="window.location.href='{{ route('equipos.create') }}'" class="btn btn-success mb-3">Add Equipo</button>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Leader</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($equipos as $equipo)
                            <tr>
                                <td>{{ $equipo->name }}</td>
                                <td>{{ $equipo->leader->name }}</td>
                                <td>
                                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
