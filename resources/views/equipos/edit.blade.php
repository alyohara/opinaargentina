<!-- resources/views/equipos/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Equipo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $equipo->name }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="leader_id">Líder</label>
                            <select name="leader_id" id="leader_id" class="form-control" required>
                                @foreach($leaders as $leader)
                                    <option value="{{ $leader->id }}" {{ $equipo->leader_id == $leader->id ? 'selected' : '' }}>{{ $leader->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="operators">Operadores</label>
                            @foreach($operators as $operator)
                                <div class="form-check">
                                    <input type="checkbox" name="operators[]" value="{{ $operator->id }}" class="form-check-input"
                                        {{ $equipo->users->contains($operator->id) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $operator->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Actualizar Equipo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
