<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Provincia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" value="{{ $state->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Código</label>
                        <input type="text" class="form-control" id="code" value="{{ $state->code }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="region" class="form-label">Región</label>
                        <input type="text" class="form-control" id="region" value="{{ $state->region }}" readonly>
                    </div>
                    <a href="{{ route('states.index') }}" class="btn btn-primary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
