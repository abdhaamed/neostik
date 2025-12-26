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
                <p class="text-base text-gray-800 mt-1" data-label="deviceId">GPS-HD-23818981289</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">IMEI Number</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceImei">862170051234567</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">SIM Card Number</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceSim">+62 812-3456-7890</p>
            </div>
        </div>

        <!-- Device Status -->
        <div class="space-y-4">
            <div>
                <label class="text-sm font-semibold text-gray-600">Connection Status</label>
                <div class="flex items-center mt-1">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    <span class="text-base text-green-600 font-medium" data-label="deviceStatus">Connected</span>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Last Update</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceUpdate">21 Dec 2025, 14:35 WIB</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Signal Strength</label>
                <div class="flex items-center mt-1">
                    <div class="flex space-x-1">
                        <div class="w-1 h-3 bg-green-500 rounded"></div>
                        <div class="w-1 h-4 bg-green-500 rounded"></div>
                        <div class="w-1 h-5 bg-green-500 rounded"></div>
                        <div class="w-1 h-6 bg-green-500 rounded"></div>
                        <div class="w-1 h-7 bg-gray-300 rounded"></div>
                    </div>
                    <span class="text-sm text-gray-800 ml-2" data-label="deviceSignal">Strong</span>
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
                <p class="text-base text-gray-800 mt-1" data-label="deviceLat">-6.402484</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Longitude</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceLng">106.794243</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Speed</label>
                <p class="text-base text-gray-800 mt-1" data-label="deviceSpeed">45 km/h</p>
            </div>
        </div>
        <div>
            <label class="text-sm font-semibold text-gray-600">Address</label>
            <p class="text-base text-gray-800 mt-1" data-label="deviceAddress">Jl. Margonda Raya No. 100, Depok, Jawa Barat 16424</p>
        </div>
    </div>

    <!-- Map Placeholder -->
    <div class="bg-gray-300 rounded-lg overflow-hidden h-80">
        <!-- Map placeholder - insert your map here -->
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
            <tbody>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">21 Dec 2025, 14:35</td>
                    <td class="py-3 px-4 text-gray-800">Device Moving</td>
                    <td class="py-3 px-4 text-gray-600">Jl. Margonda Raya, Depok</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Active
                        </span>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">21 Dec 2025, 13:20</td>
                    <td class="py-3 px-4 text-gray-800">Engine Started</td>
                    <td class="py-3 px-4 text-gray-600">Jl. Raya Bogor, Jakarta</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            Started
                        </span>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">21 Dec 2025, 12:45</td>
                    <td class="py-3 px-4 text-gray-800">Device Idle</td>
                    <td class="py-3 px-4 text-gray-600">Gudang Pusat, Jakarta</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                            Idle
                        </span>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">21 Dec 2025, 12:30</td>
                    <td class="py-3 px-4 text-gray-800">Engine Stopped</td>
                    <td class="py-3 px-4 text-gray-600">Gudang Pusat, Jakarta</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                            Stopped
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">21 Dec 2025, 09:15</td>
                    <td class="py-3 px-4 text-gray-800">Device Connected</td>
                    <td class="py-3 px-4 text-gray-600">Gudang Pusat, Jakarta</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Connected
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>