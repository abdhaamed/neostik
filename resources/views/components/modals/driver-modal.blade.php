<!-- Modal Add/Edit Driver -->
<div id="driverModal" class="fixed inset-0 bg-transparent bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Add New Driver</h3>
            <button onclick="closeDriverModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="driverForm" onsubmit="saveDriver(event)" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter driver name">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="driver@email.com">
                    <p class="text-xs text-gray-500 mt-1">Password will be the username part (before @)</p>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="phone" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="+62 812 3456 7890">
                </div>

                <!-- License Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        License Number <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="license_number" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="LIC-123456">
                </div>

                <!-- Vehicle Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Vehicle Type
                    </label>
                    <select 
                        name="vehicle_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select vehicle type</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Car">Car</option>
                        <option value="Van">Van</option>
                        <option value="Truck">Truck</option>
                    </select>
                </div>

                <!-- Vehicle Plate -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Vehicle Plate
                    </label>
                    <input 
                        type="text" 
                        name="vehicle_plate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="B 1234 XYZ">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date of Birth
                    </label>
                    <input 
                        type="date" 
                        name="date_of_birth"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status (only show for edit) -->
                <div id="statusField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select 
                        name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>

                <!-- Availability (only show for edit) -->
                <div id="availabilityField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Availability
                    </label>
                    <select 
                        name="availability"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="available">Available</option>
                        <option value="on_duty">On Duty</option>
                        <option value="on_leave">On Leave</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Address
                    </label>
                    <textarea 
                        name="address" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter driver address"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="closeDriverModal()"
                    class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Save Driver
                </button>
            </div>
        </form>
    </div>
</div>

