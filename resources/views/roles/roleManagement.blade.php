@extends('layouts.MainLayout')

@section('section')

<div class="max-w-7xl mx-auto py-10 px-4">

    <!-- Header -->
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🛡️ Role Management</h1>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Role -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <form method="POST" action="/roles" class="grid md:grid-cols-4 gap-4">
            @csrf

            {{-- <select name="device_id" class="border p-2 rounded">
                <option disabled value="">Select Device</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->model_name }}</option>
                @endforeach
            </select> --}}

            <input type="hidden" name="device_id" value="{{ $current_device_id }}">
            <input name="role_name" placeholder="Role Name" class="border p-2 rounded" required>

            <input name="role_id" placeholder="Role ID (0/14)" class="border p-2 rounded" required>

            <input name="description" placeholder="Description" class="border p-2 rounded">

            <button class="bg-blue-500 text-white rounded px-4 py-2">
                + Add Role
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">Device</th>
                    <th class="px-6 py-4">Role Name</th>
                    <th class="px-6 py-4">Role ID</th>
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach($roles as $key => $role)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">{{ $key+1 }}</td>

                        <td class="px-6 py-4">
                            {{ $role->device->model_name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            {{ $role->role_name }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs
                                {{ $role->role_id == 14 ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ $role->role_id }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $role->description }}
                        </td>

                        <td class="px-6 py-4 flex gap-2">

                            <!-- Edit -->
                            <button onclick="openModal({{ $role->id }})"
                                class="bg-yellow-400 px-3 py-1 rounded text-white">
                                Edit
                            </button>

                            <!-- Delete -->
                            <form method="POST" action="/roles/{{ $role->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 px-3 py-1 rounded text-white">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                    <!-- Edit Modal -->
                    <div id="modal-{{ $role->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">

                        <div class="bg-white p-6 rounded-xl w-96">

                            <form method="POST" action="/roles/{{ $role->id }}">
                                @csrf
                                @method('PUT')

                                <input name="role_name" value="{{ $role->role_name }}" class="border p-2 w-full mb-2 rounded">
                                <input name="role_id" value="{{ $role->role_id }}" class="border p-2 w-full mb-2 rounded">
                                <input name="description" value="{{ $role->description }}" class="border p-2 w-full mb-4 rounded">

                                <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
                                    Update
                                </button>
                            </form>

                            <button onclick="closeModal({{ $role->id }})"
                                class="mt-2 text-red-500 text-sm">
                                Close
                            </button>

                        </div>

                    </div>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<script>
function openModal(id){
    document.getElementById('modal-'+id).classList.remove('hidden');
}
function closeModal(id){
    document.getElementById('modal-'+id).classList.add('hidden');
}
</script>

@endsection