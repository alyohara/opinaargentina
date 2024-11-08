<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Teléfono') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('telefonos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="movil" class="form-label">Móvil</label>
                            <input type="text" class="form-control" id="movil" name="movil" required>
                        </div>
                        <div class="mb-3">
                            <label for="state_id" class="form-label">Provincia</label>
                            <select class="form-control" id="state_id" name="state_id" required>
                                <option value="">Seleccione una provincia</option>
                                @foreach($provincias as $provincia)
                                    <option value="{{ $provincia->id }}">{{ $provincia->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="city_id" class="form-label">Ciudad</label>
                            <select class="form-control" id="city_id" name="city_id" required>
                                <option value="">Seleccione una ciudad</option>
{{--                                @foreach($ciudades as $ciudad)--}}
{{--                                    <option value="{{ $ciudad->id }}">{{ $ciudad->name }}</option>--}}
{{--                                @endforeach--}}
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
