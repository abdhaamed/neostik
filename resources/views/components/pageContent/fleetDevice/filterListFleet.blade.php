<!-- Title & Add Button -->
<div class="p-4 border-b border-gray-200 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Fleet & Device</h2>
        <p class="text-xs text-gray-500">Manager Center / Fleet & Device</p>
    </div>
    <button
        onclick="toggleFleetForm()"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Add New Fleet</span>
    </button>
</div>

<!-- Fleet Form (Hidden Initially) -->
<div id="fleetFormContainer" class="hidden p-4 border-b border-gray-200 bg-gray-50">
    <form method="POST" action="{{ route('manager.fleet-device.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <!-- Fleet Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-gray-600">License Plate</label>
                <input type="text" name="license_plate" class="w-full border-gray-300 rounded p-2" placeholder="Enter license plate">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Serial Number</label>
                <input type="text" name="serial_number" class="w-full border-gray-300 rounded p-2" placeholder="Enter serial number">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Category</label>
                <select name="category_id" class="w-full border-gray-300 rounded p-2">
                    <option value="">Select category</option>
                    @foreach($fleetCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Capacity</label>
                <input type="text" name="capacity" class="w-full border-gray-300 rounded p-2" placeholder="Enter capacity">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600">Fleet Image</label>
                <input type="file" name="image" class="w-full text-gray-800">
            </div>
        </div>

        <!-- Device Assignment -->
        <div class="mt-4">
            <h4 class="font-semibold text-gray-800 mb-2">Device Assignment (Optional)</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-600">Device Code</label>
                    <input type="text" name="device_code" class="w-full border-gray-300 rounded p-2" placeholder="Enter device code">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">IMEI Number</label>
                    <input type="text" name="imei_number" class="w-full border-gray-300 rounded p-2" placeholder="Enter IMEI">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">SIM Card Number</label>
                    <input type="text" name="sim_card_number" class="w-full border-gray-300 rounded p-2" placeholder="Enter SIM number">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Connection Status</label>
                    <select name="connection_status" class="w-full border-gray-300 rounded p-2">
                        <option value="connected">Connected</option>
                        <option value="disconnected">Disconnected</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Save Fleet
            </button>
        </div>
    </form>
</div>

<!-- Filter Section -->
<div class="ps-4 pe-4 pt-4 border-b border-gray-200 bg-orange-50">
    <!-- ... Filter section remains the same ... -->
</div>

<!-- Script -->
<script>
    let fleetFormOpen = false;
    function toggleFleetForm() {
        fleetFormOpen = !fleetFormOpen;
        const container = document.getElementById('fleetFormContainer');
        if(fleetFormOpen) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
</script>
