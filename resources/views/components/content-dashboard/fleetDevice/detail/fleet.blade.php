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
                        <div class="text-white px-8 py-2 rounded shadow-lg">
                            <span class="text-base font-bold">200 kg</span>
                        </div>
                    </div>
                    <!-- Truck Image Placeholder -->
                    <img src="" alt="Truck" class="w-64 h-32 bg-gray-300 rounded object-cover">
                </div>
            </div>

            <!-- Route Status Timeline -->
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Unassigned</p>
                        <p class="text-sm text-gray-600">Belum ada penugasan</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full flex bg-gray-300 items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Assigned</p>
                        <p class="text-sm text-gray-600">Tugas telah diberikan ke kurir/driver</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full flex bg-gray-300 items-center justify-center flex-shrink-0 mt-1">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">En Route</p>
                        <p class="text-sm text-gray-600">Dalam Perjalanan</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
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
        <div class="bg-gray-300 rounded-lg overflow-hidden">
            <!-- Map placeholder - insert your map here -->
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
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">Unassigned</td>
                    <td class="py-3 px-4 text-gray-800">PIC Gudang</td>
                    <td class="py-3 px-4 text-gray-600">Staff gudang menyiapkan dokumen</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">Assigned</td>
                    <td class="py-3 px-4 text-gray-800">Lead Logistic</td>
                    <td class="py-3 px-4 text-gray-600">Tugas pengiriman diberikan ke driver</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">En Route</td>
                    <td class="py-3 px-4 text-gray-800">Davin Pratama</td>
                    <td class="py-3 px-4 text-gray-600">Menuju lokasi tujuan</td>
                    <td class="py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                            Show
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-800">Completed</td>
                    <td class="py-3 px-4 text-gray-800">PT Sejahtera Selalu</td>
                    <td class="py-3 px-4 text-gray-600">Barang diterima oleh penerima</td>
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