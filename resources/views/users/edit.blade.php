<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}">
        <label for="password">Password (leave blank to keep current password):</label>
        <input type="password" name="password" id="password">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        <button type="submit">Update</button>
    </form>
</x-app-layout>
