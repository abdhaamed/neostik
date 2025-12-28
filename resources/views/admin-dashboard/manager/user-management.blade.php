@extends('layouts.app')
@section('content')
<div class="flex h-screen">
    <!-- Left Bar - Always visible (Logo + Hamburger) -->
    @include('components.sidebar.humbergerButton')

    <!-- Sidebar - Default hidden -->
    <aside id="sidebar" class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
        @include('components.sidebar.sidebar')
        @include('components.sidebar.profile')
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col" style="margin-left: 60px;">
        <header class="px-4 py-2">
            <!-- Header Top with Tabs -->
            @include('components.headerTop.headerTab')
            <!-- Status Badges -->
            @include('components.headerTop.badgeStatus')

            <!-- Breadcrumb and Action Buttons -->
            <div class="flex items-center justify-between m-6">
                <p class="text-sm text-gray-800">Driver Management / Status Board</p>
                <div class="flex items-center gap-3">
                    <!-- Driver Overview Button -->
                    <button class="page-button px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm transition-colors" data-page="statusboard">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Driver Overview
                    </button>
                    <!-- Assignment Request Panel Button -->
                    <button class="page-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 flex items-center gap-2 text-sm transition-colors" data-page="assignment">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Assignment Request Panel
                    </button>
                </div>
            </div>
        </header>

        <main class="flex-1">
            <!-- Status Board Content (Default Active) -->
            <div id="contentStatusboard" class="page-content bg-white p-6 rounded shadow">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Status Board</h2>
                    <div class="flex items-center gap-3">

                        <!-- Export Button -->
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </button>

                        <!-- Add New Driver Button -->
                        <button id="btnAddDriver" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add new Driver
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full" id="driverTable">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">ID Driver</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Name</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Email</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Phone</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Status</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Availability</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Rating</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Deliveries</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="driverTableBody">
                            @forelse($drivers as $driver)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->driver_id }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->email }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->phone }}</td>
                                <td class="py-4 px-4">
                                    <span class="flex items-center gap-2 text-sm">
                                        <span class="w-2 h-2 rounded-full {{ $driver->status === 'active' ? 'bg-green-500' : ($driver->status === 'suspended' ? 'bg-red-500' : 'bg-gray-400') }}"></span>
                                        <span class="text-gray-700 capitalize">{{ $driver->status }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="flex items-center gap-2 text-sm">
                                        <span class="w-2 h-2 rounded-full {{ $driver->availability === 'available' ? 'bg-green-500' : ($driver->availability === 'on_duty' ? 'bg-yellow-500' : 'bg-gray-400') }}"></span>
                                        <span class="text-gray-700 capitalize">{{ str_replace('_', ' ', $driver->availability) }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ number_format($driver->rating, 1) }}/5</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->completed_deliveries }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="editDriver('{{ $driver->id }}')" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="deleteDriver('{{ $driver->id }}', '{{ $driver->name }}')" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-500">No drivers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Assignment Request Panel Content (Hidden by default) -->
            <div id="contentAssignment" class="page-content bg-white rounded shadow hidden">
                <main class="flex-1 overflow-hidden flex">
                    <!-- Left Section - Driver List -->
                    <div class="bg-white border-r border-gray-200 flex flex-col">
                        <!-- Filter & Search -->
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="relative flex-1">
                                    <input type="text" id="searchDriverAssignment" placeholder="Search Driver"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Driver Cards -->
                        <div class="flex-1 overflow-y-auto p-4">
                            <div class="grid grid-cols-2 gap-4">
                                @forelse($drivers as $driver)
                                <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer driver-card" data-driver-id="{{ $driver->id }}">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                                                {{ substr($driver->name, 0, 1) }}
                                            </div>
                                            <h4 class="text-gray-800 font-semibold text-sm">{{ $driver->name }}</h4>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Driver ID -->
                                    <p class="text-xs text-gray-500 mb-3">{{ $driver->driver_id }}</p>
                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-3 gap-2 mb-3">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Delivery</div>
                                            <div class="text-lg font-bold text-gray-800">{{ $driver->completed_deliveries }}</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Task</div>
                                            <div class="text-lg font-bold text-gray-800">0</div> <!-- Bisa dihitung dari tasks -->
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Rating</div>
                                            <div class="text-lg font-bold text-gray-800">{{ number_format($driver->rating, 1) }}/5</div>
                                        </div>
                                    </div>
                                    <!-- Productivity -->
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">Productivity</span>
                                        <span class="font-semibold text-gray-700">0%</span>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-2 text-center py-8 text-gray-500">
                                    No drivers available
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Section - Task Assignment Form -->
                    <div class="flex-1 bg-gray-50 overflow-y-auto" id="taskFormPanel">
                        <!-- PLACEHOLDER MESSAGE -->
                        <div id="placeholderTaskMessage" class="h-full flex flex-col justify-center items-center text-gray-400">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">Select a driver to assign task</p>
                        </div>

                        <!-- TASK FORM (DEFAULT HIDDEN) -->
                        <form id="taskFormDetail" class="p-6 hidden" enctype="multipart/form-data">
                            <!-- Hidden driver_id -->
                            <input type="hidden" id="selectedDriverId" name="driver_id">

                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Column - Task Information -->
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Task Information</h3>
                                        <p class="text-sm text-gray-600 mb-4">Assign task to selected driver</p>

                                        <!-- Nomor Tugas -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Tugas</label>
                                            <input type="text" name="task_number" placeholder="TASK-250405-ABC123" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Tanggal Pengiriman -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengiriman</label>
                                            <input type="date" name="delivery_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Pilih Fleet -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Fleet *</label>
                                            <select name="fleet_id" id="fleetSelect" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">-- Pilih Fleet --</option>
                                                @foreach($fleets as $fleet)
                                                <option value="{{ $fleet->id }}">
                                                    {{ $fleet->fleet_id }}
                                                    @if($fleet->device)
                                                    - {{ $fleet->device->device_id }}
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Asal Pengiriman -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Asal Pengiriman</label>
                                            <textarea name="origin" placeholder="Gudang Pusat, Jakarta" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>

                                        <!-- Tujuan Pengiriman -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan Pengiriman</label>
                                            <textarea name="destination" placeholder="PT ABC, Bandung" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>

                                        <!-- Jenis Barang -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Barang</label>
                                            <input type="text" name="cargo_type" placeholder="Elektronik" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Jumlah / Volume Barang -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah / Volume Barang</label>
                                            <input type="text" name="cargo_volume" placeholder="10 koli / 2.5 ton" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Nomor Kendaraan -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kendaraan</label>
                                            <input type="text" name="vehicle_plate" placeholder="B 1234 ABC" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Documents & Evidence -->
                                <div class="space-y-6">

                                    <!-- Operating Costs -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Operating costs</h3>
                                        <p class="text-sm text-gray-600 mb-4">Initial proof before the driver leaves</p>

                                        <!-- Nominal Uang Jalan -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Uang Jalan (Rp)</label>
                                            <input type="number" name="operating_cost" placeholder="150000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex justify-end gap-3 pt-4">
                                        <button type="button" onclick="resetTaskForm()" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            Assign Task
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
    </div>

    <!-- Modal Add/Edit Driver -->
    @include('components.modals.driver-modal')

    <script>
        // Handle form submit
        // Handle form submit
document.getElementById('taskFormDetail').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const driverId = document.getElementById('selectedDriverId').value;
    const fleetId = document.getElementById('fleetSelect').value;

    if (!driverId || !fleetId) {
        alert('Please select a driver and a fleet.');
        return;
    }

    // Tambahkan ke FormData (jika belum)
    formData.set('driver_id', driverId);
    formData.set('fleet_id', fleetId);

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Assigning...
    `;

    try {
        const response = await fetch('{{ route("manager.tasks.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            // ✅ LANGSUNG RELOAD TANPA ALERT
            window.location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed to assign task'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    } catch (err) {
        console.error('Error:', err);
        alert('Network error. Check console.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

        function attachDriverCardListeners() {
            document.querySelectorAll('.driver-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remove border from all
                    document.querySelectorAll('.driver-card').forEach(c => {
                        c.classList.remove('border-orange-400');
                        c.classList.add('border-gray-300');
                    });
                    // Add border to selected
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-orange-400');

                    // Set hidden driver_id
                    const driverId = this.dataset.driverId;
                    document.getElementById('selectedDriverId').value = driverId;

                    // Show form, hide placeholder
                    document.getElementById('placeholderTaskMessage').classList.add('hidden');
                    document.getElementById('taskFormDetail').classList.remove('hidden');
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Page switching
            const pageButtons = document.querySelectorAll('.page-button');
            const pageContents = document.querySelectorAll('.page-content');
            attachDriverCardListeners();

            pageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetPage = this.getAttribute('data-page');

                    pageButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-600', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-700');
                    });

                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-blue-600', 'text-white');

                    pageContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    const targetId = 'content' + targetPage.charAt(0).toUpperCase() + targetPage.slice(1);
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            // Add Driver Button
            document.getElementById('btnAddDriver').addEventListener('click', function() {
                openDriverModal();
            });

            // Search Driver
            let searchTimeout;
            document.getElementById('searchDriver').addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchDrivers(e.target.value);
                }, 500);
            });
        });

        // Global functions for modal
        let currentDriverId = null;

        function openDriverModal(driverId = null) {
            currentDriverId = driverId;
            const modal = document.getElementById('driverModal');
            const modalTitle = document.getElementById('modalTitle');
            const form = document.getElementById('driverForm');
            const statusField = document.getElementById('statusField');
            const availabilityField = document.getElementById('availabilityField');

            form.reset();

            if (driverId) {
                modalTitle.textContent = 'Edit Driver';
                statusField.classList.remove('hidden');
                availabilityField.classList.remove('hidden');

                // Load driver data via AJAX
                fetch(`/manager/users/${driverId}`)
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            const driver = response.data;
                            // Populate form with driver data
                            form.querySelector('[name="name"]').value = driver.name || '';
                            form.querySelector('[name="email"]').value = driver.email || '';
                            form.querySelector('[name="phone"]').value = driver.phone || '';
                            form.querySelector('[name="license_number"]').value = driver.license_number || '';
                            form.querySelector('[name="vehicle_type"]').value = driver.vehicle_type || '';
                            form.querySelector('[name="vehicle_plate"]').value = driver.vehicle_plate || '';
                            form.querySelector('[name="date_of_birth"]').value = driver.date_of_birth || '';
                            form.querySelector('[name="status"]').value = driver.status || 'active';
                            form.querySelector('[name="availability"]').value = driver.availability || 'available';
                            form.querySelector('[name="address"]').value = driver.address || '';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading driver:', error);
                        alert('Failed to load driver data');
                    });
            } else {
                modalTitle.textContent = 'Add New Driver';
                statusField.classList.add('hidden');
                availabilityField.classList.add('hidden');
            }

            modal.classList.remove('hidden');
        }

        function closeDriverModal() {
            document.getElementById('driverModal').classList.add('hidden');
            currentDriverId = null;
        }

        function saveDriver(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    const url = currentDriverId ?
        `/manager/users/${currentDriverId}` :
        '/manager/users';

    const method = currentDriverId ? 'PUT' : 'POST';

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Saving...
    `;

    // ✅ PERBAIKAN: Kirim sebagai FormData untuk PUT juga
    if (currentDriverId) {
        formData.append('_method', 'PUT');
    }

    fetch(url, {
            method: 'POST', // ✅ Selalu POST, tapi dengan _method untuk PUT
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
                // ✅ HAPUS Content-Type, biar browser yang set otomatis untuk FormData
            },
            body: formData // ✅ Kirim FormData langsung, bukan JSON
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => Promise.reject(err));
            }
            return res.json();
        })
        .then(response => {
            if (response.success) {
                // ✅ LANGSUNG RELOAD TANPA ALERT
                closeDriverModal();
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            } else {
                throw new Error(response.message || 'Save failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Tampilkan pesan error yang lebih detail
            let errorMessage = 'Error saving driver';
            if (error.errors) {
                // Laravel validation errors
                errorMessage += ':\n' + Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                errorMessage += ': ' + error.message;
            }
            
            alert(errorMessage);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
}

        function editDriver(driverId) {
            openDriverModal(driverId);
        }

        function deleteDriver(driverId, driverName) {
            if (!confirm(`Are you sure you want to delete ${driverName}?`)) return;

            fetch(`/manager/users/${driverId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    alert('Error deleting driver: ' + error.message);
                });
        }

        function searchDrivers(query) {
            if (!query) {
                location.reload();
                return;
            }

            fetch(`/manager/users/search?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        updateDriverTable(response.data);
                    }
                });
        }

        function updateDriverTable(drivers) {
            const tbody = document.getElementById('driverTableBody');

            if (drivers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="py-8 text-center text-gray-500">No drivers found</td></tr>';
                return;
            }

            tbody.innerHTML = drivers.map(driver => `
        <tr class="border-b border-gray-100 hover:bg-gray-50">
            <td class="py-4 px-4 text-sm text-gray-700">${driver.driver_id}</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.name}</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.email}</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.phone}</td>
            <td class="py-4 px-4">
                <span class="flex items-center gap-2 text-sm">
                    <span class="w-2 h-2 rounded-full ${driver.status === 'active' ? 'bg-green-500' : (driver.status === 'suspended' ? 'bg-red-500' : 'bg-gray-400')}"></span>
                    <span class="text-gray-700 capitalize">${driver.status}</span>
                </span>
            </td>
            <td class="py-4 px-4">
                <span class="flex items-center gap-2 text-sm">
                    <span class="w-2 h-2 rounded-full ${driver.availability === 'available' ? 'bg-green-500' : (driver.availability === 'on_duty' ? 'bg-yellow-500' : 'bg-gray-400')}"></span>
                    <span class="text-gray-700 capitalize">${driver.availability.replace('_', ' ')}</span>
                </span>
            </td>
            <td class="py-4 px-4 text-sm text-gray-700">${parseFloat(driver.rating).toFixed(1)}/5</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.completed_deliveries}</td>
            <td class="py-4 px-4">
                <div class="flex items-center gap-2">
                    <button onclick="editDriver(${driver.id})" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button onclick="deleteDriver(${driver.id}, '${driver.name}')" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
        }

        function openDriverModal() {
            const modal = document.getElementById('driverModal');
            const box = modal.children[0];

            // tampilkan modal
            modal.classList.remove('hidden');

            // background blur + fade
            modal.classList.add(
                'backdrop-blur-md',
                'bg-black/30',
                'transition-opacity',
                'duration-300',
                'opacity-100'
            );

            // reset awal animasi
            box.classList.add(
                'transition-all',
                'duration-300',
                'ease-out',
                'scale-95',
                'opacity-0'
            );

            requestAnimationFrame(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeDriverModal() {
            const modal = document.getElementById('driverModal');
            const box = modal.children[0];

            // animasi keluar
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove(
                    'backdrop-blur-md',
                    'bg-black/30',
                    'opacity-100'
                );
            }, 300);
        }

        function resetTaskForm() {
            document.getElementById('taskFormDetail').classList.add('hidden');
            document.getElementById('placeholderTaskMessage').classList.remove('hidden');
            document.getElementById('taskFormDetail').reset();
            document.getElementById('selectedDriverId').value = '';
            document.querySelectorAll('.driver-card').forEach(card => {
                card.classList.remove('border-orange-400');
                card.classList.add('border-gray-300');
            });
        }
    </script>
    @endsection