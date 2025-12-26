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
        </header>
        <main class="flex-1 overflow-hidden flex">
            <!-- Left Section - Fleet List -->
            <div class="w-2/5 bg-white border-r border-gray-200 flex flex-col">
                <!-- Filter & Add Button -->
                @include('components.content-dashboard.fleetDevice.filterListFleet')
                <!-- Fleet Cards -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        @if($fleets->isEmpty())
                        <p class="text-gray-500 text-center py-8">No fleet available.</p>
                        @else
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($fleets as $fleet)
                            <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer fleet-card"
                                data-fleet-id="{{ $fleet->fleet_id }}"
                                data-status="{{ $fleet->status }}"
                                data-device-id="{{ $fleet->device?->device_id ?? '' }}"
                                data-imei="{{ $fleet->device?->imei ?? '' }}"
                                data-sim="{{ $fleet->device?->sim_card ?? '' }}">
                                <!-- Header -->
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-gray-800 text-md">{{ $fleet->fleet_id }}</h4>
                                    @php
                                    $statusColor = match($fleet->status) {
                                    'Completed' => 'bg-green-500',
                                    'En Route' => 'bg-blue-500',
                                    'Assigned' => 'bg-orange-500',
                                    default => 'bg-gray-400',
                                    };
                                    @endphp
                                    <div class="flex items-center space-x-1">
                                        <span class="w-2 h-2 {{ $statusColor }} rounded-full"></span>
                                        <span class="text-xs text-gray-600">{{ $fleet->status }}</span>
                                    </div>
                                </div>

                                <!-- Content Grid -->
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div class="flex flex-col">
                                        <span class="text-md font-bold text-gray-800">00:00:00</span>
                                        <span class="text-xs text-gray-500 mt-1">—</span>
                                    </div>

                                    <div class="flex flex-col space-y-2 relative pl-6">
                                        <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gray-300"></div>
                                        @foreach(['Completed', 'En Route', 'Assigned', 'Unassigned'] as $status)
                                        <div class="flex items-center space-x-2 relative z-10">
                                            <div class="w-3 h-3 rounded-full {{ $status === $fleet->status ? match($status) {
                                        'Completed' => 'bg-green-500',
                                        'En Route' => 'bg-blue-500',
                                        'Assigned' => 'bg-orange-500',
                                        default => 'bg-gray-400'
                                    } : 'bg-gray-400' }} border-2 border-white"></div>
                                            <span class="text-xs text-gray-700">{{ $status }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div></div>
                                </div>

                                <!-- Truck -->
                                <div class="bg-gray-100 rounded h-24 overflow-hidden">
                                    <img
                                        src="{{ $fleet->image_url }}"
                                        alt="Fleet Image"
                                        class="w-full h-full object-cover">
                                </div>

                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Right Section - Details -->
            <div class="flex-1 bg-gray-50 overflow-y-auto" id="detailPanel">

                <!-- DEFAULT / PLACEHOLDER -->
                <div id="placeholderMessage" class="h-full flex flex-col justify-center items-center text-gray-400 text-lg">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <p class="text-gray-500">Choose a fleet to see detail</p>
                </div>

                <!-- REAL DETAIL (HIDDEN FIRST) -->
                <div id="realDetail" class="hidden">
                    @include('components.content-dashboard.fleetDevice.detailFleetDevice')
                </div>

            </div>

        </main>
    </div>
</div>

<!-- Add Fleet Modal -->
<div id="addFleetModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Add New Fleet</h3>
            <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="addFleetForm" enctype="multipart/form-data" method="POST" action="{{ route('manager.fleet-device.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Fleet ID</label>
                <input type="text" name="fleet_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="e.g. HD-99671212">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Device ID</label>
                <input type="text" name="device_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="e.g. GPS-HD-99671212">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">IMEI</label>
                <input type="text" name="imei" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="862170051234567">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">SIM Card Number</label>
                <input type="text" name="sim_card"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="+62 812-3456-7890">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Unassigned">Unassigned</option>
                    <option value="Assigned">Assigned</option>
                    <option value="En Route">En Route</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Fleet Image
                </label>
                <input type="file"
                    name="image"
                    accept="image/*"
                    class="w-full text-sm text-gray-600
                            file:mr-4 file:py-2 file:px-4
                            file:rounded file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-600
                            hover:file:bg-blue-100">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add Fleet</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal
    function openModal() {
        document.getElementById('addFleetModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addFleetModal').classList.add('hidden');
    }
    document.getElementById('addFleetModal').addEventListener('click', e => {
        if (e.target === e.currentTarget) closeModal();
    });

    // Tab switching
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                tabButtons.forEach(b => b.classList.replace('text-blue-600', 'text-gray-600').classList.remove('border-b-2', 'border-blue-600'));
                btn.classList.replace('text-gray-600', 'text-blue-600').classList.add('border-b-2', 'border-blue-600');
                tabContents.forEach(c => c.classList.add('hidden'));
                document.getElementById('content' + btn.dataset.tab.charAt(0).toUpperCase() + btn.dataset.tab.slice(1)).classList.remove('hidden');
            });
        });
    });

    // Card click → show detail
    function attachCardListeners() {
        document.querySelectorAll('.fleet-card').forEach(card => {
            if (!card.dataset.listened) {
                card.addEventListener('click', function() {
                    const fleetId = this.dataset.fleetId;
                    const status = this.dataset.status;
                    const deviceId = this.dataset.deviceId || 'GPS-' + fleetId;
                    const imei = this.dataset.imei || '86217005XXXXXXX';
                    const sim = this.dataset.sim || '+62 —';

                    document.getElementById('placeholderMessage').classList.add('hidden');
                    document.getElementById('realDetail').classList.remove('hidden');

                    // Update header
                    document.querySelector('[data-label="fleetId"]').textContent = fleetId;

                    // Update device data
                    const fields = {
                        deviceId,
                        imei,
                        deviceSim: sim,
                        deviceStatus: 'Connected',
                        deviceUpdate: new Date().toLocaleString('id-ID') + ' WIB',
                        deviceSignal: 'Strong',
                        deviceLat: '-6.40248' + Math.floor(Math.random() * 10),
                        deviceLng: '106.79424' + Math.floor(Math.random() * 10),
                        deviceSpeed: Math.floor(Math.random() * 80) + ' km/h',
                        deviceAddress: 'Auto-generated location'
                    };

                    Object.entries(fields).forEach(([key, val]) => {
                        const el = document.querySelector(`[data-label="${key}"]`);
                        if (el) el.textContent = val;
                    });

                    // Active status di header
                    const statusEl = document.querySelector('#realDetail .text-green-600');
                    if (statusEl) {
                        let colorClass = 'bg-gray-400',
                            textColor = 'text-gray-600';
                        if (status === 'En Route') {
                            colorClass = 'bg-blue-500';
                            textColor = 'text-blue-600';
                        } else if (status === 'Assigned') {
                            colorClass = 'bg-orange-500';
                            textColor = 'text-orange-600';
                        } else if (status === 'Completed') {
                            colorClass = 'bg-green-500';
                            textColor = 'text-green-600';
                        }
                        statusEl.querySelector('span').className = ``;
                        statusEl.className = `flex items-center text-sm ${textColor}`;
                        statusEl.lastElementChild.textContent = status;
                    }

                    // Default ke tab Fleet
                    document.querySelector('.tab-button[data-tab="fleet"]').click();
                });
                card.dataset.listened = 'true';
            }
        });
    }

    // Form submit (AJAX)
    document.getElementById('addFleetForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    try {
        const res = await fetch('/manager/fleet-device', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!res.ok) {
            const text = await res.text();
            throw new Error(text);
        }

        const data = await res.json();

        if (data.success) {
            closeModal();
            this.reset();
            window.location.reload();
        } else {
            alert(data.message || 'Failed to save');
        }

    } catch (err) {
        console.error('FETCH ERROR:', err);
        alert('Network error (lihat console)');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Add Fleet';
    }
});


    // Attach listeners saat load
    document.addEventListener('DOMContentLoaded', attachCardListeners);
</script>
@endsection