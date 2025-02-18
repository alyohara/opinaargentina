<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Persona') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3>{{ $person->name }} {{ $person->surname }}</h3>
                    <p>Email: {{ $person->email }}</p>
                    <p>Teléfono: {{ $person->telephone }}</p>
                    <p>Celular: {{ $person->cellphone }}</p>
                    <p>Ciudad: {{ $person->city->name }}</p>
                    <a href="{{ route('people.edit', $person) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('people.destroy', $person) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-button">Eliminar</button>
                    </form>
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
