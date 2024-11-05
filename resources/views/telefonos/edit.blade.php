<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Teléfono') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('telefonos.update', $telefono) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $telefono->telefono }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="movil" class="form-label">Móvil</label>
                            <input type="text" class="form-control" id="movil" name="movil" value="{{ $telefono->movil }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <select class="form-control" id="provincia" name="provincia" required>
                                <option value="">Seleccione una provincia</option>
                                @foreach($provincias as $provincia)
                                    <option value="{{ $provincia->id }}" {{ $telefono->city->state_id == $provincia->id ? 'selected' : '' }}>{{ $provincia->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="city_id" class="form-label">Ciudad</label>
                            <select class="form-control" id="city_id" name="city_id" required>
                                <option value="">Seleccione una ciudad</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}" {{ $telefono->city_id == $ciudad->id ? 'selected' : '' }}>{{ $ciudad->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('provincia').addEventListener('change', function () {
            const provinciaId = this.value;
            const citySelect = document.getElementById('city_id');
            citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

            if (provinciaId) {
                fetch(`/api/states/${provinciaId}/cities`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
</x-app-layout>
