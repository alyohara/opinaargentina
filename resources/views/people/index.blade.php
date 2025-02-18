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
                    <button onclick="window.location.href='{{ route('people.create') }}'" class="btn btn-success mb-3">Agregar Persona</button>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Celular</th>
                            <th>Ciudad</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($people as $person)
                            <tr>
                                <td>{{ $person->name }}</td>
                                <td>{{ $person->surname }}</td>
                                <td>{{ $person->email }}</td>
                                <td>{{ $person->telephone }}</td>
                                <td>{{ $person->cellphone }}</td>
                                <td>{{ $person->city->name }}</td>
                                <td>
                                    <a href="{{ route('people.show', $person) }}" class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('people.edit', $person) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('people.destroy', $person) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $people->links() }}
                    </div>
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
