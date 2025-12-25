@extends('driver.layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Profile Settings</h1>
        <p class="text-gray-600">Manage your personal information and account settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col items-center mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-3">
                        {{ $driver->initials }}
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $driver->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $driver->driver_id }}</p>
                </div>

                <nav class="space-y-2">
                    <button onclick="showTab('personal')" data-tab="personal" class="tab-button w-full text-left px-4 py-3 rounded-lg font-medium transition-colors bg-blue-50 text-blue-600">
                        Personal Information
                    </button>
                    <button onclick="showTab('vehicle')" data-tab="vehicle" class="tab-button w-full text-left px-4 py-3 rounded-lg font-medium transition-colors text-gray-600 hover:bg-gray-50">
                        Vehicle Information
                    </button>
                    <button onclick="showTab('security')" data-tab="security" class="tab-button w-full text-left px-4 py-3 rounded-lg font-medium transition-colors text-gray-600 hover:bg-gray-50">
                        Security
                    </button>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Personal Information Tab -->
            <div id="tabPersonal" class="tab-content bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Personal Information</h2>
                <form id="formPersonal" onsubmit="updateProfile(event)">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ $driver->name }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" value="{{ $driver->email }}" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ $driver->phone }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ $driver->date_of_birth }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $driver->address }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vehicle Information Tab -->
            <div id="tabVehicle" class="tab-content bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Vehicle Information</h2>
                <form id="formVehicle" onsubmit="updateVehicle(event)">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                            <input type="text" name="license_number" value="{{ $driver->license_number }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Type</label>
                            <select name="vehicle_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select vehicle type</option>
                                <option value="Motorcycle" {{ $driver->vehicle_type == 'Motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="Car" {{ $driver->vehicle_type == 'Car' ? 'selected' : '' }}>Car</option>
                                <option value="Van" {{ $driver->vehicle_type == 'Van' ? 'selected' : '' }}>Van</option>
                                <option value="Truck" {{ $driver->vehicle_type == 'Truck' ? 'selected' : '' }}>Truck</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Plate Number</label>
                            <input type="text" name="vehicle_plate" value="{{ $driver->vehicle_plate }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="B 1234 XYZ">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Update Vehicle Info
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Tab -->
            <div id="tabSecurity" class="tab-content bg-white rounded-lg shadow-lg p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Change Password</h2>
                <form id="formPassword" onsubmit="updatePassword(event)">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" name="new_password" required minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" required minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tab switching
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remove active state from all buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('bg-blue-50', 'text-blue-600');
            btn.classList.add('text-gray-600');
        });

        // Show selected tab
        document.getElementById('tab' + tabName.charAt(0).toUpperCase() + tabName.slice(1)).classList.remove('hidden');

        // Add active state to clicked button
        const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
        activeBtn.classList.add('bg-blue-50', 'text-blue-600');
        activeBtn.classList.remove('text-gray-600');
    }

    // Update Profile
    function updateProfile(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Saving...';

        fetch('{{ route("driver.profile.update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    showToast(response.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(response.message, 'error');
                }
            })
            .catch(error => {
                showToast('Failed to update profile', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Save Changes';
            });
    }

    // Update Vehicle
    function updateVehicle(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Updating...';

        fetch('{{ route("driver.profile.vehicle") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    showToast(response.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(response.message, 'error');
                }
            })
            .catch(error => {
                showToast('Failed to update vehicle info', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Update Vehicle Info';
            });
    }

    // Update Password
    function updatePassword(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Changing...';

        fetch('{{ route("driver.profile.password") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    showToast(response.message, 'success');
                    form.reset();
                } else {
                    showToast(response.message, 'error');
                }
            })
            .catch(error => {
                showToast('Failed to change password', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Change Password';
            });
    }
</script>
@endpush
@endsection