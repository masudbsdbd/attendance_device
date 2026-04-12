<!DOCTYPE html>
<html>
<head>
    <title>Device Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">⚙️ Device Dashboard</h1>
        <span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-sm font-medium">
            ● Online
        </span>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Device Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @php
            $items = [
                'IP Address' => $deviceInfo['ip'],
                'Port' => $deviceInfo['port'],
                'Platform' => $deviceInfo['platform'],
                'Operating System' => $deviceInfo['os'],
                'Firmware' => $deviceInfo['firmware'],
                'Serial Number' => $deviceInfo['serial'],
                'Device Name' => $deviceInfo['device_name'],
                'Current Time' => $deviceInfo['time'],
            ];
        @endphp

        @foreach($items as $label => $value)
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">

                <p class="text-sm text-gray-500 mb-1">{{ $label }}</p>

                <h2 class="text-lg font-semibold text-gray-800 break-all">
                    {{ str_replace(['~Platform=', '~OS=', '~ZKFPVersion=', '~SerialNumber=', '~DeviceName='], '', $value) }}
                </h2>

            </div>
        @endforeach

    </div>

    <!-- Actions -->
    <div class="mt-10 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-gray-800 mb-4">⚡ Device Actions</h2>

        <div class="flex flex-wrap gap-4">

            <!-- Test Sound -->
            <form method="POST" action="/device/test-sound">
                @csrf
                <button class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl transition shadow">
                    🔊 Test Sound
                </button>
            </form>

            <!-- Restart -->
            <form method="POST" action="/device/restart">
                @csrf
                <button class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl transition shadow">
                    🔄 Restart
                </button>
            </form>

            <!-- Shutdown -->
            <form method="POST" action="/device/shutdown">
                @csrf
                <button onclick="return confirm('Are you sure? Device will shutdown!')"
                        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl transition shadow">
                    ⛔ Shutdown
                </button>
            </form>

        </div>

    </div>

</div>

</body>
</html>