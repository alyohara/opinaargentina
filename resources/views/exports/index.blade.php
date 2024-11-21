<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exported Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>File Path</th>
                            <th>Created At</th>
                            <th>User</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exports as $export)
                            <tr>
                                <td>{{ $export->id }}</td>
                                <td><a href="{{ url(str_replace('storage//storage', '', $export->file_path)) }}" target="_blank">{{ str_replace('/storage/storage/', '', $export->file_path) }}</a></td>
                                <td>{{ $export->created_at }}</td>
                                                              <td>{{ $export->created_at }}</td>
                                <td>{{ $export->user->name }}</td>
                                <td>
                                    <a href="{{ Storage::url($export->file_path) }}" class="btn btn-primary" target="_blank">Download</a>                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $exports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
