

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('Crear Provincia') }}
</h2>
</x-slot>

<div class="py-12">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('states.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
