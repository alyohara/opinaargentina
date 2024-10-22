<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">Users</h1>
                <a href="{{ route('users.create') }}" class="text-blue-500 hover:underline">Add User</a>
                <ul class="mt-4">
                    @foreach($users as $user)
                        <li class="mb-2">
                            <div class="flex justify-between items-center">
                                <span>{{ $user->name }} ({{ $user->email }})</span>
                                <div>
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
