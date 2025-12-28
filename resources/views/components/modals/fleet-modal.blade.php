<!-- Add Fleet Modal -->
<div id="addFleetModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300">
    <div class="bg-white rounded-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto transform transition-all duration-300 animate-[modalSlideIn_0.3s_ease-out]">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Add New Fleet</h3>
            <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors duration-200 hover:rotate-90 transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="addFleetForm" enctype="multipart/form-data" method="POST" action="{{ route('manager.fleet-device.store') }}">
            @csrf

            <h4 class="font-semibold text-gray-700 mb-3">Fleet Information</h4>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fleet ID</label>
                    <input type="text" name="fleet_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 focus:border-blue-500 focus:shadow-lg"
                        placeholder="e.g. HD-99671212">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                    <input type="number" step="0.01" name="weight"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 focus:border-blue-500 focus:shadow-lg"
                        placeholder="e.g. 200">
                </div>
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fleet Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 file:transition-all file:duration-200 file:cursor-pointer">
                </div>
            </div>

            <h4 class="font-semibold text-gray-700 mb-3 mt-6">Device Information</h4>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Device ID</label>
                    <input type="text" name="device_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 focus:border-blue-500 focus:shadow-lg"
                        placeholder="e.g. GPS-HD-99671212">
                </div>
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">IMEI</label>
                    <input type="text" name="imei" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 focus:border-blue-500 focus:shadow-lg"
                        placeholder="862170051234567">
                </div>
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">SIM Card Number</label>
                    <input type="text" name="sim_card"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 focus:border-blue-500 focus:shadow-lg"
                        placeholder="+62 812-3456-7890">
                </div>
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="number" step="0.0000001" name="latitude"
                        class="w-full px-3 py-2 border border-gray-300 rounded transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:shadow-lg"
                        placeholder="-6.2088" value="-6.2088">
                </div>
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="number" step="0.0000001" name="longitude"
                        class="w-full px-3 py-2 border border-gray-300 rounded transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:shadow-lg"
                        placeholder="106.8456" value="106.8456">
                </div>
                <div class="transform transition-all duration-200 hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 focus:border-blue-500 focus:shadow-lg"
                        placeholder="e.g. Jl. Sudirman No. 123, Jakarta">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50 transition-all duration-200 hover:shadow-md active:scale-95 transform">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-all duration-200 hover:shadow-lg active:scale-95 transform hover:-translate-y-0.5">Add Fleet</button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
</style>