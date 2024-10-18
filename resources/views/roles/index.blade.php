<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles and Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div>
                            <x-label for="name" value="{{ __('Role Name') }}" />
                            <x-input id="name" type="text" name="name" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="permissions" value="{{ __('Permissions') }}" />
                            @foreach($permissions as $permission)
                                <div>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                    <label>{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <x-button>
                                {{ __('Create Role') }}
                            </x-button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Existing Roles') }}</h3>
                        <ul>
                            @foreach($roles as $role)
                                <li class="mt-2">
                                    {{ $role->name }}
                                    <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="ml-4">
                                            {{ __('Delete') }}
                                        </x-button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
