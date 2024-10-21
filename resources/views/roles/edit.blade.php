<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles and Permissions') }}
        </h2>
    </x-slot>
    <h1>Edit Role</h1>
    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Role Name:</label>
        <input type="text" name="name" id="name" value="{{ $role->name }}">
        <label for="permissions">Permissions:</label>
        <select name="permissions[]" id="permissions" multiple>
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}" {{ $role->permissions->contains($permission) ? 'selected' : '' }}>
                    {{ $permission->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Update</button>
    </form>
</x-app-layout>
