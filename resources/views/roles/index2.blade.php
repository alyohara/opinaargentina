<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles and Permissions') }}
        </h2>
    </x-slot>
    <h1>Roles</h1>
    <a href="{{ route('roles.create') }}">Create Role</a>
    <ul>
        @foreach($roles as $role)
            <li>{{ $role->name }}
                <a href="{{ route('roles.edit', $role) }}">Edit</a>
                <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>
