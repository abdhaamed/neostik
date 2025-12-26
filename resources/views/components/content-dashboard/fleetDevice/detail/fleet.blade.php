<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Route</h3>
        <button class="flex items-center space-x-2 text-blue-600 hover:text-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="text-sm font-medium">Edit Route</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Side: Truck and Status -->
        <div>
            <!-- Truck with Weight Badge -->
            <div class="flex justify-center mb-6">
                <div style="position: relative; display: inline-block;">
                    <!-- Weight Badge Overlay -->
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
                        <div class="bg-blue-600 text-white px-8 py-2 rounded shadow-lg">
                            <span class="text-base font-bold" data-label="fleetWeight">0 kg</span>
                        </div>
                    </div>
                    <!-- Truck Image -->
                    <img src="" alt="Truck" data-label="fleetImage" class="w-64 h-32 bg-gray-300 rounded object-cover">
                </div>
            </div>

            <!-- Route Status Timeline -->
            <div class="space-y-4">
                <div class="flex items-start space-x-3" data-status="Unassigned">
                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Unassigned</p>
                        <p class="text-sm text-gray-600">Belum ada penugasan</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3" data-status="Assigned">
                    <div class="w-6 h-6 rounded-full flex bg-gray-300 items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Assigned</p>
                        <p class="text-sm text-gray-600">Tugas telah diberikan ke kurir/driver</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3" data-status="En Route">
                    <div class="w-6 h-6 rounded-full flex bg-gray-300 items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">En Route</p>
                        <p class="text-sm text-gray-600">Dalam Perjalanan</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3" data-status="Completed">
                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Completed</p>
                        <p class="text-sm text-gray-600">Pengiriman selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Map -->
        <div class="bg-gray-300 rounded-lg overflow-hidden h-80">
            <!-- Map placeholder - insert your map here -->
            <div class="w-full h-full flex items-center justify-center text-gray-500">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <p class="text-sm">Map Integration Coming Soon</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bukti Operasional Section -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Bukti Operasional</h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Recipient</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Description</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Report</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors" data-bukti-status="Unassigned">
                    <td class="py-3 px-4 text-gray-800">Unassigned</td>
                    <td class="py-3 px-4 text-gray-800" data-bukti="recipient">—</td>
                    <td class="py-3 px-4 text-gray-600" data-bukti="description">—</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors" data-bukti-status="Assigned">
                    <td class="py-3 px-4 text-gray-800">Assigned</td>
                    <td class="py-3 px-4 text-gray-800" data-bukti="recipient">—</td>
                    <td class="py-3 px-4 text-gray-600" data-bukti="description">—</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors" data-bukti-status="En Route">
                    <td class="py-3 px-4 text-gray-800">En Route</td>
                    <td class="py-3 px-4 text-gray-800" data-bukti="recipient">—</td>
                    <td class="py-3 px-4 text-gray-600" data-bukti="description">—</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors" data-bukti-status="Completed">
                    <td class="py-3 px-4 text-gray-800">Completed</td>
                    <td class="py-3 px-4 text-gray-800" data-bukti="recipient">—</td>
                    <td class="py-3 px-4 text-gray-600" data-bukti="description">—</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>