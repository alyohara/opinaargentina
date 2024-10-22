<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;">
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Add User</a>
                <table class="min-w-full mt-4">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-700">Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-700">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-700">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">{{ $user->name }}</td>
                            <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">
                                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-yellow-900 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition mr-2">Edit</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
