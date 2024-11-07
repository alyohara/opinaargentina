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
</x-app-layout>
