<!-- Fleet Detail Panel - Sliding from Right -->
<div id="fleetDetail" class="fixed right-0 top-0 h-full w-96 bg-white border-l border-gray-300 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <!-- Header -->
    <div class="bg-orange-500 text-white p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div>
                <h2 id="detailPlateNumber" class="text-lg font-bold">{{ $fleet->license_plate }}</h2>
                <p id="detailCargo" class="text-sm opacity-90">{{ $fleet->category?->name ?? 'No Category' }}</p>
            </div>
        </div>
        <button onclick="closeFleetDetail()" class="text-white hover:bg-orange-600 p-2 rounded">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Driver Info -->
    @php
    // Cari task aktif: status 'approved' atau 'pending'
    $activeTask = $fleet->tasks->firstWhere(function ($task) {
    return in_array($task->status, ['approved', 'pending']);
    });

    $driverUser = $activeTask?->driver?->user;
    @endphp

    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                @if($driverUser?->profile_photo_path)
                <img src="{{ asset('storage/' . $driverUser->profile_photo_path) }}"
                    alt="{{ $driverUser->name }}"
                    class="w-6 h-6 rounded-full object-cover">
                @else
                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                @endif
            </div>
            <div>
                @if($driverUser)
                <p id="detailDriverName" class="font-bold text-gray-800">{{ $driverUser->name }}</p>
                <p class="text-xs text-gray-500">{{ $driverUser->email }}</p>
                @else
                <p id="detailDriverName" class="font-bold text-gray-800">No Driver Assigned</p>
                <p class="text-xs text-gray-500">—</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex border-b border-gray-200">
        <button onclick="switchTab('overview')" id="tabOverview" class="flex-1 px-4 py-3 text-sm font-medium text-white bg-blue-500 border-b-2 border-blue-500">
            Overview
        </button>
        <button onclick="switchTab('playback')" id="tabPlayback" class="flex-1 px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
            Playback
        </button>
    </div>

    <!-- Overview Content -->
    <div id="overviewContent" class="p-4">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Object Information</h3>
        </div>

        <!-- Info Cards Grid -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            @php
            $latestGps = $fleet->device?->gpsLogs()->latest()->first();
            $speed = $latestGps?->speed ?? 0;
            $address = $latestGps?->address ?? 'Unknown location';
            $lastUpdate = $latestGps?->timestamp?->format('d-m-Y H:i') ?? '—';
            @endphp

            <!-- Speed -->
            <div class="border border-gray-300 rounded-lg p-3">
                <div class="flex items-center space-x-2 mb-1">
                    <i class="fas fa-tachometer-alt text-blue-500 w-5 h-5"></i>
                    <span class="text-xs font-semibold text-gray-600">Speed</span>
                </div>
                <p class="text-lg font-bold text-gray-800">{{ $speed }} km/h</p>
            </div>

            <!-- Fuel -->
            <div class="border border-gray-300 rounded-lg p-3">
                <div class="flex items-center space-x-2 mb-1">
                    <i class="fas fa-gas-pump text-green-500 w-5 h-5"></i>
                    <span class="text-xs font-semibold text-gray-600">Fuel</span>
                </div>
                <p class="text-lg font-bold text-gray-800">—</p> <!-- Belum ada kolom fuel di model -->
            </div>

            <!-- Power -->
            <div class="border border-gray-300 rounded-lg p-3">
                <div class="flex items-center space-x-2 mb-1">
                    <i class="fas fa-bolt text-yellow-500 w-5 h-5"></i>
                    <span class="text-xs font-semibold text-gray-600">Power</span>
                </div>
                <p class="text-lg font-bold text-gray-800">—</p>
            </div>

            <!-- Temperature -->
            <div class="border border-gray-300 rounded-lg p-3">
                <div class="flex items-center space-x-2 mb-1">
                    <i class="fas fa-temperature-high text-red-500 w-5 h-5"></i>
                    <span class="text-xs font-semibold text-gray-600">Temperature</span>
                </div>
                <p class="text-lg font-bold text-gray-800">—</p>
            </div>
        </div>

        <!-- Logs Section -->
        <div class="mt-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-gray-800">Logs</h3>
                <button class="text-xs text-gray-500 hover:text-gray-700 flex items-center space-x-1">
                    <span>Filters</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
            </div>

            <!-- Logs Table -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Last Update</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($latestGps)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-gray-700">{{ $lastUpdate }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $address }}</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="2" class="px-3 py-2 text-gray-500 text-center">No GPS data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Playback Content (Hidden by default) -->
    <div id="playbackContent" class="p-4 hidden">
        <div class="text-center py-12 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z" />
            </svg>
            <p class="text-lg font-medium">Playback Feature</p>
            <p class="text-sm mt-2">Track history and route playback will be displayed here</p>
        </div>
    </div>
</div>