<!DOCTYPE html>
<html>
<head>
    <title>Devices</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto py-10 px-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📡 Device Manager {{session('current_device_id')}}</h1>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add Device -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <form method="POST" action="/devices" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <input name="model_name" placeholder="Device Name" class="border p-2 rounded" required>
            <input name="ip" placeholder="IP Address" class="border p-2 rounded" required>
            <input name="port" placeholder="Port" value="4370" class="border p-2 rounded">
            <button class="bg-blue-500 text-white rounded px-4 py-2">+ Add</button>
        </form>
    </div>

    <!-- Device Cards -->
    <div class="grid md:grid-cols-3 gap-6">

    @foreach($devices as $device)
        <div class="group bg-white border border-gray-200 rounded-3xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">

            <!-- Top gradient accent -->
            <div class="h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

            <div class="p-6">

                <!-- Header -->
                <div class="flex justify-between items-start mb-5">
                    <div class="flex items-center gap-3">
                        <!-- Device Icon -->
                        <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 tracking-tight">
                                {{ $device->model_name }}
                            </h2>
                            <p class="text-xs text-gray-500 mt-0.5">ID: #{{ str_pad($device->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <span class="inline-flex items-center gap-2 text-sm font-medium px-4 py-1.5 rounded-2xl
                        {{ $device->status 
                            ? 'bg-emerald-100 text-emerald-700' 
                            : 'bg-red-100 text-red-700' }}">
                        <span class="w-2.5 h-2.5 rounded-full {{ $device->status ? 'bg-emerald-500 animate-pulse' : 'bg-red-500' }}"></span>
                        {{ $device->status ? 'Online' : 'Offline' }}
                    </span>
                </div>

                <!-- Device Info -->
                <div class="bg-gray-50 rounded-2xl p-4 mb-6 space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-gray-400">📍</span>
                        <span class="text-gray-600">IP: <span class="font-mono font-medium text-gray-800">{{ $device->ip }}</span></span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-gray-400">🔌</span>
                        <span class="text-gray-600">Port: <span class="font-medium text-gray-800">{{ $device->port }}</span></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-3 gap-3">
                    
                    <!-- View Details Button (New) -->
                    <a href="/device-info/{{ $device->id }}"
                       class="col-span-1 flex items-center justify-center gap-2 bg-white border border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3 rounded-2xl transition-all active:scale-[0.97]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5 16.477 5 20.268 7.943 21.542 12 20.268 16.057 16.477 19 12 19 7.523 19 3.732 16.057 2.458 12z" />
                        </svg>
                        Details
                    </a>

                    <!-- Test Button -->
                    <a href="/devices/test/{{ $device->id }}"
                       class="col-span-1 flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 rounded-2xl transition-all active:scale-[0.97]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894L18 21H6l-2.236-8.106A2 2 0 015.236 10H10" />
                        </svg>
                        Test
                    </a>

                    
                    
                    <!-- Delete Button -->
                    <form method="POST" action="/devices/{{ $device->id }}" class="col-span-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure you want to delete this device?')"
                                class="w-full flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-2xl transition-all active:scale-[0.97]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6h12v12" />
                            </svg>
                            Delete
                        </button>
                    </form>

                </div>

            </div>
        </div>
    @endforeach

</div>

</div>

</body>
</html>