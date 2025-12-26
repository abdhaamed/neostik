<!-- Device Information Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800">Device Information</h3>
        <button class="flex items-center space-x-2 text-blue-600 hover:text-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="text-sm font-medium">Edit Device</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Device Details -->
        <div class="space-y-4">
            <div>
                <label class="text-sm font-semibold text-gray-600">Device ID</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceId">—</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">IMEI Number</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceImei">—</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">SIM Card Number</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceSim">—</p>
            </div>
        </div>

        <!-- Device Status -->
        <div class="space-y-4">
            <div>
                <label class="text-sm font-semibold text-gray-600">Connection Status</label>
                <div class="flex items-center mt-1">
                    <span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span>
                    <span class="text-base text-gray-600 font-medium" data-label="deviceStatus">Disconnected</span>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Last Update</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceUpdate">—</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Signal Strength</label>
                <div class="flex items-center mt-1">
                    <div class="flex space-x-1">
                        <div class="w-1 h-3 bg-gray-300 rounded" data-signal-bar="0"></div>
                        <div class="w-1 h-4 bg-gray-300 rounded" data-signal-bar="1"></div>
                        <div class="w-1 h-5 bg-gray-300 rounded" data-signal-bar="2"></div>
                        <div class="w-1 h-6 bg-gray-300 rounded" data-signal-bar="3"></div>
                        <div class="w-1 h-7 bg-gray-300 rounded" data-signal-bar="4"></div>
                    </div>
                    <span class="text-sm text-gray-800 ml-2" data-label="deviceSignal">—</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Current Location Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Current Location</h3>

    <div class="space-y-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-semibold text-gray-600">Latitude</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceLat">—</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Longitude</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceLng">—</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Speed</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceSpeed">0 km/h</p>
            </div>
        </div>
        <div>
            <label class="text-sm font-semibold text-gray-600">Address</label>
            <p class="text-base text-gray-800 mt-1" data-label="deviceAddress">—</p>
        </div>
    </div>

    <!-- Map Placeholder -->
    <div class="bg-gray-300 rounded-lg overflow-hidden h-80">
        <!-- Map placeholder - insert your map here -->
        <div class="w-full h-full flex items-center justify-center text-gray-500">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <p class="text-sm">Map Integration Coming Soon</p>
            </div>
        </div>
    </div>
</div>

<!-- Device History Section -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Device Activity History</h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Timestamp</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Event</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Location</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody id="deviceHistoryBody">
                <!-- History will be dynamically loaded -->
                <tr>
                    <td colspan="4" class="py-8 text-center text-gray-500">
                        No device history available
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
