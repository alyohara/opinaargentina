<!-- resources/views/roles/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
