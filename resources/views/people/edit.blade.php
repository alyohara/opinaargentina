<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Persona') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('people.update', $person->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $person->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Apellido</label>
                            <input type="text" id="surname" name="surname" class="form-control" value="{{ $person->surname }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $person->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Teléfono</label>
                            <input type="text" id="telephone" name="telephone" class="form-control" value="{{ $person->telephone }}">
                        </div>
                        <div class="mb-3">
                            <label for="cellphone" class="form-label">Celular</label>
                            <input type="text" id="cellphone" name="cellphone" class="form-control" value="{{ $person->cellphone }}">
                        </div>
                        <div class="mb-3">
                            <label for="state_id" class="form-label">Estado</label>
                            <select id="state_id" name="state_id" class="form-control" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ $person->city->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="city_id" class="form-label">Ciudad</label>
                            <select id="city_id" name="city_id" class="form-control" required>
                                <option value="">Seleccione una ciudad</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $person->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('state_id').addEventListener('change', function () {
            const stateId = this.value;
            const citySelect = document.getElementById('city_id');
            citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

            if (stateId) {
                fetch(`/api/states/${stateId}/cities`)
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