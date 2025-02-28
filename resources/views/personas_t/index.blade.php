<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Personas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <button onclick="window.location.href='{{ route('personas_t.create') }}'"
                            class="btn btn-success mb-3">Agregar Persona
                    </button>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="GET" action="{{ route('personas_t.index') }}">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="apellido_y_nombre" class="form-control" placeholder="Apellido y Nombre" value="{{ request('apellido_y_nombre') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="dni" class="form-control" placeholder="DNI" value="{{ request('dni') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="localidad" class="form-control" placeholder="Localidad" value="{{ request('localidad') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="provincia" class="form-control" placeholder="Provincia" value="{{ request('provincia') }}">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Apellido y Nombre</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Móvil</th>
                            <th>Email</th>
                            <th>Localidad</th>
                            <th>Provincia</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($personas as $persona)
                            <tr>
                                <td>{{ $persona->id }}</td>
                                <td>{{ $persona->apellido_y_nombre }}</td>
                                <td>{{ $persona->dni }}</td>
                                <td>{{ $persona->telefono }}</td>
                                <td>{{ $persona->movil }}</td>
                                <td>{{ $persona->email }}</td>
                                <td>{{ $persona->localidad ? $persona->localidad->nombre : '' }}</td>
                                <td>{{ $persona->localidad && $persona->localidad->provincia ? $persona->localidad->provincia->nombre : '' }}</td>
                                <td>
                                    <a href="{{ route('personas_t.show', $persona) }}" class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('personas_t.edit', $persona) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('personas_t.destroy', $persona) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $personas->appends(request()->query())->links() }}
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
    </script>
</x-app-layout>
