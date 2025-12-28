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
            @include('components.headerTop.headerTab')
            @include('components.headerTop.badgeStatus')
        </header>

        <main class="flex-1 overflow-hidden flex">
            <!-- Left Section - Fleet List -->
            <div class="w-2/5 bg-white border-r border-gray-200 flex flex-col">
                @include('components.content-dashboard.fleetDevice.filterListFleet')

                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    @if($fleets->isEmpty())
                    <p class="text-gray-500 text-center py-8">No fleet available.</p>
                    @else
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($fleets as $fleet)
                        @php
                        // Ambil bukti operasional untuk mendapatkan informasi driver/recipient
                        $buktiOperasional = $fleet->getBuktiOperasional();
                        $currentBukti = collect($buktiOperasional)->firstWhere('status', $fleet->status);
                        $driverName = $currentBukti['recipient'] ?? 'Not Assigned';

                        // Tentukan informasi berdasarkan status
                        $statusInfo = match($fleet->status) {
                        'Unassigned' => [
                        'label' => 'Status',
                        'value' => 'Waiting Assignment',
                        'icon' => '
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        ],
                        'Assigned' => [
                        'label' => 'Driver',
                        'value' => $driverName,
                        'icon' => '
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />'
                        ],
                        'En Route' => [
                        'label' => 'Driver',
                        'value' => $driverName,
                        'icon' => '
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'
                        ],
                        'Completed' => [
                        'label' => 'Delivered By',
                        'value' => $driverName,
                        'icon' => '
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        ],
                        default => [
                        'label' => 'Status',
                        'value' => 'Unknown',
                        'icon' => '
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        ]
                        };
                        @endphp
                        <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer fleet-card"
                            data-fleet-id="{{ $fleet->id }}"
                            data-fleetCode="{{ $fleet->fleet_id }}"
                            data-status="{{ $fleet->status }}"
                            data-accepted="{{ $fleet->accepted_by_admin ? 'true' : 'false' }}"
                            data-weight="{{ $fleet->weight ?? 0 }}"
                            data-image="{{ $fleet->image ? asset('storage/fleets/' . $fleet->image) : '' }}"
                            data-deviceId="{{ $fleet->device?->device_id ?? '' }}"
                            data-imei="{{ $fleet->device?->imei ?? '' }}"
                            data-sim="{{ $fleet->device?->sim_card ?? '' }}"
                            data-connection="{{ $fleet->device?->connection_status ?? 'Disconnected' }}"
                            data-signal="{{ $fleet->device?->signal_strength ?? 'Good' }}"
                            data-lat="{{ $fleet->device?->latitude ?? '' }}"
                            data-lng="{{ $fleet->device?->longitude ?? '' }}"
                            data-speed="{{ $fleet->device?->speed ?? 0 }}"
                            data-address="{{ $fleet->device?->address ?? '' }}"
                            data-lastUpdate="{{ $fleet->device?->last_update ? $fleet->device->last_update->format('d M Y, H:i') : '' }}"
                            data-bukti="{{ json_encode($fleet->getBuktiOperasional(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}">

                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-gray-800 text-md font-semibold">{{ $fleet->fleet_id }}</h4>
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

                            <!-- Info Section with Icon -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $statusInfo['icon'] !!}
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $statusInfo['label'] }}</p>
                                        <p class="text-sm font-semibold text-gray-800 truncate mt-0.5">{{ $statusInfo['value'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Fleet Image -->
                            <div class="bg-gray-100 rounded-lg h-24 overflow-hidden">
                                @if($fleet->image)
                                <img src="{{ asset('storage/fleets/' . $fleet->image) }}" alt="Fleet Image" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Section - Details -->
            <div class="flex-1 bg-gray-50 overflow-y-auto" id="detailPanel">
                <!-- Placeholder -->
                <div id="placeholderMessage" class="h-full flex flex-col justify-center items-center text-gray-400 text-lg">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <p class="text-gray-500">Choose a fleet to see detail</p>
                </div>

                <!-- REAL DETAIL (HIDDEN BY DEFAULT) -->
                <div id="realDetail" class="hidden p-6">

                    <!-- Fleet Header -->
                    <div class="mb-6">
                        <h2 id="fleetHeaderCode" class="text-2xl font-bold text-gray-800" data-label="fleetId">FLEET-001</h2>
                        <div class="flex items-center text-sm mt-1">
                            <span class="w-3 h-3 rounded-full mr-2"></span>
                            <span>Unassigned</span>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-6">
                            <button class="tab-button py-3 px-1 border-b-2 font-medium text-sm text-gray-600 border-transparent hover:text-gray-700 hover:border-gray-300" data-tab="fleet">
                                Fleet
                            </button>
                            <button class="tab-button py-3 px-1 border-b-2 font-medium text-sm text-gray-600 border-transparent hover:text-gray-700 hover:border-gray-300" data-tab="device">
                                Device
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content: Fleet -->
                    <div id="contentFleet" class="tab-content hidden">

                        <!-- Route Section (Fleet Info + Truck + Timeline) -->
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Route</h3>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Left Side: Truck and Status -->
                                <div>
                                    <!-- Truck with Weight Badge -->
                                    <div class="flex justify-center mb-6">
                                        <div style="position: relative; display: inline-block;">
                                            <!-- Weight Badge Overlay -->
                                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
                                                <div class="bg-transparent text-gray-800 px-8 py-2 rounded shadow-lg">
                                                    <span class="text-base font-bold" data-label="fleetWeight">0 kg</span>
                                                </div>
                                            </div>
                                            <!-- Truck Image -->
                                            <img src="" alt="Truck" data-label="fleetImage" class="w-64 h-32 bg-gray-300 rounded object-cover">
                                        </div>
                                    </div>

                                    <!-- Route Status Timeline -->
                                    <div class="space-y-4">
                                        <div class="flex items-start space-x-3" data-bukti-status="Unassigned">
                                            <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                                                <div class="w-3 h-3 rounded-full bg-white"></div>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">Unassigned</p>
                                                <p class="text-sm text-gray-600" data-bukti="recipient">—</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start space-x-3" data-bukti-status="Assigned">
                                            <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                                                <div class="w-3 h-3 rounded-full bg-white"></div>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">Assigned</p>
                                                <p class="text-sm text-gray-600" data-bukti="recipient">—</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start space-x-3" data-bukti-status="En Route">
                                            <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                                                <div class="w-3 h-3 rounded-full bg-white"></div>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">En Route</p>
                                                <p class="text-sm text-gray-600" data-bukti="recipient">—</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start space-x-3" data-bukti-status="Completed">
                                            <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0 mt-1">
                                                <div class="w-3 h-3 rounded-full bg-white"></div>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">Completed</p>
                                                <p class="text-sm text-gray-600" data-bukti="recipient">—</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Right Side: Map -->
                                <!-- Leaflet Map Container -->
                                <div id="fleetMap" class="rounded-lg overflow-hidden h-80 w-full">
                                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                            </svg>
                                            <p class="text-sm">Map Integration Coming Soon</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bukti Operasional Section (as Table) -->
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
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

                        <!-- Admin Acceptance Section (Dynamic) -->
                        <div id="acceptSection" class="mt-4 p-4 bg-blue-50 rounded-lg hidden">
                            <h3 class="font-semibold text-blue-800 mb-2">Admin Verification</h3>
                            <p class="text-sm text-blue-700 mb-3">This task is completed by the driver. Please verify and accept.</p>
                            <form id="acceptForm" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Accept Completed Task
                                </button>
                            </form>
                        </div>

                    </div>

                    <!-- Tab Content: Device -->
                    <div id="contentDevice" class="tab-content hidden">

                        <!-- Device Information -->
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-800">Device Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                                <div class="w-1 h-3 bg-gray-300 rounded" data-signal-bar></div>
                                                <div class="w-1 h-4 bg-gray-300 rounded" data-signal-bar></div>
                                                <div class="w-1 h-5 bg-gray-300 rounded" data-signal-bar></div>
                                                <div class="w-1 h-6 bg-gray-300 rounded" data-signal-bar></div>
                                                <div class="w-1 h-7 bg-gray-300 rounded" data-signal-bar></div>
                                            </div>
                                            <span class="text-sm text-gray-800 ml-2" data-label="deviceSignal">—</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Location -->
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Current Location</h3>
                            <div class="space-y-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="text-sm font-semibold text-gray-600">Latitude</label>
                                        <p data-label="deviceLat">—</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold text-gray-600">Longitude</label>
                                        <p data-label="deviceLng">—</p>
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
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Fleet Modal -->
@include('components.modals.fleet-modal')

<script>
    // Modal
    function openModal() {
        document.getElementById('addFleetModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addFleetModal').classList.add('hidden');
    }
    document.getElementById('addFleetModal')?.addEventListener('click', e => {
        if (e.target === e.currentTarget) closeModal();
    });

    // Tab switching
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                tabButtons.forEach(b => {
                    b.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                    b.classList.add('text-gray-600');
                });
                btn.classList.remove('text-gray-600');
                btn.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabContents.forEach(c => c.classList.add('hidden'));
                const tabName = btn.dataset.tab.charAt(0).toUpperCase() + btn.dataset.tab.slice(1);
                document.getElementById('content' + tabName)?.classList.remove('hidden');
            });
        });
    });

    // Card click → show detail
    function attachCardListeners() {
        document.querySelectorAll('.fleet-card').forEach(card => {
            if (!card.dataset.listened) {
                card.addEventListener('click', function() {
                    const data = this.dataset;

                    document.getElementById('placeholderMessage').classList.add('hidden');
                    document.getElementById('realDetail').classList.remove('hidden');

                    // Header fleet code
                    document.getElementById('fleetHeaderCode').textContent = data.fleetcode;

                    // Status badge
                    const statusEl = document.querySelector('#realDetail .flex.items-center.text-sm');
                    if (statusEl) {
                        const colorMap = {
                            'En Route': {
                                text: 'text-blue-600'
                            },
                            'Assigned': {
                                text: 'text-orange-600'
                            },
                            'Completed': {
                                text: 'text-green-600'
                            },
                            'Unassigned': {
                                text: 'text-gray-600'
                            }
                        };
                        const colors = colorMap[data.status] || colorMap['Unassigned'];
                        statusEl.className = `flex items-center text-sm ${colors.text}`;
                        const textSpan = statusEl.querySelector('span:last-child');
                        if (textSpan) textSpan.textContent = data.status;
                    }

                    // Fleet data
                    const fleetFields = {
                        'fleetWeight': data.weight ? `${data.weight} kg` : '0 kg',
                        'fleetStatus': data.status
                    };
                    Object.entries(fleetFields).forEach(([key, val]) => {
                        const el = document.querySelector(`[data-label="${key}"]`);
                        if (el) el.textContent = val;
                    });

                    // Fleet image
                    const fleetImg = document.querySelector('[data-label="fleetImage"]');
                    if (fleetImg) {
                        fleetImg.src = data.image || '';
                        fleetImg.classList.toggle('hidden', !data.image);
                    }

                    // Timeline & bukti
                    updateRouteTimeline(data.status);
                    try {
                        const bukti = JSON.parse(data.bukti);
                        updateBuktiOperasional(bukti);
                    } catch (e) {
                        console.error('Error parsing bukti:', e);
                    }

                    // Device data
                    const deviceFields = {
                        'deviceId': data.deviceid || 'GPS-' + data.fleetcode,
                        'deviceImei': data.imei || '—',
                        'deviceSim': data.sim || '—',
                        'deviceStatus': data.connection || 'Disconnected',
                        'deviceUpdate': data.lastupdate || '—',
                        'deviceSignal': data.signal || 'Good',
                        'deviceLat': data.lat || '—',
                        'deviceLng': data.lng || '—',
                        'deviceSpeed': data.speed ? `${data.speed} km/h` : '0 km/h',
                        'deviceAddress': data.address || '—'
                    };
                    Object.entries(deviceFields).forEach(([key, val]) => {
                        const el = document.querySelector(`[data-label="${key}"]`);
                        if (el) el.textContent = val;
                    });

                    updateConnectionStatus(data.connection);
                    updateSignalBars(data.signal);

                    // Handle acceptance form visibility
                    const acceptSection = document.getElementById('acceptSection');
                    if (data.status === 'Completed' && data.accepted === 'false') {
                        acceptSection?.classList.remove('hidden');
                        const form = document.getElementById('acceptForm');
                        if (form) {
                            form.action = `/manager/fleet/${data.fleetId}/accept`;
                        }
                    } else {
                        acceptSection?.classList.add('hidden');
                    }

                    // Default tab
                    document.querySelector('.tab-button[data-tab="fleet"]')?.click();

                    updateFleetMap(data.lat, data.lng, data.address);

                    initFleetMap();
                });
                card.dataset.listened = 'true';
            }
        });
    }

    function updateRouteTimeline(currentStatus) {
        const statuses = ['Unassigned', 'Assigned', 'En Route', 'Completed'];
        const colorMap = {
            'Unassigned': 'bg-gray-300',
            'Assigned': 'bg-orange-500',
            'En Route': 'bg-blue-500',
            'Completed': 'bg-green-500'
        };
        statuses.forEach(status => {
            const el = document.querySelector(`[data-bukti-status="${status}"]`);
            if (el) {
                const circle = el.querySelector('.w-6');
                if (circle) {
                    circle.className = `w-6 h-6 rounded-full ${status === currentStatus ? colorMap[status] : 'bg-gray-300'} flex items-center justify-center flex-shrink-0 mt-1`;
                }
            }
        });
    }

    function updateBuktiOperasional(bukti) {
        // Buat map untuk akses cepat
        const buktiMap = {};
        bukti.forEach(item => {
            buktiMap[item.status] = item;
        });

        // Update TABEL (cari di tbody)
        document.querySelectorAll('#contentFleet table tbody tr').forEach(row => {
            const status = row.dataset.buktiStatus;
            if (buktiMap[status]) {
                const recipientEl = row.querySelector('[data-bukti="recipient"]');
                const descEl = row.querySelector('[data-bukti="description"]');
                if (recipientEl) recipientEl.textContent = buktiMap[status].recipient || '—';
                if (descEl) descEl.textContent = buktiMap[status].description || '—';
            }
        });

        // Update TIMELINE (cari di .space-y-4 di dalam #contentFleet)
        document.querySelectorAll('#contentFleet .space-y-4 > div').forEach(item => {
            const status = item.dataset.buktiStatus;
            if (buktiMap[status]) {
                const recipientEl = item.querySelector('[data-bukti="recipient"]');
                if (recipientEl) recipientEl.textContent = buktiMap[status].recipient || '—';
            }
        });
    }

    function updateConnectionStatus(status) {
        const statusEl = document.querySelector('[data-label="deviceStatus"]');
        if (statusEl) {
            const parent = statusEl.closest('.flex.items-center');
            const dot = parent?.querySelector('.w-3.h-3');
            let colorClass = 'bg-red-500',
                textColor = 'text-red-600';
            if (status === 'Connected') {
                colorClass = 'bg-green-500';
                textColor = 'text-green-600';
            } else if (status === 'Idle') {
                colorClass = 'bg-yellow-500';
                textColor = 'text-yellow-600';
            }
            if (dot) dot.className = `w-3 h-3 ${colorClass} rounded-full mr-2`;
            statusEl.className = `text-base ${textColor} font-medium`;
        }
    }

    function updateSignalBars(strength) {
        const bars = document.querySelectorAll('[data-signal-bar]');
        const strengthMap = {
            'Weak': 1,
            'Fair': 2,
            'Good': 3,
            'Strong': 4,
            'Excellent': 5
        };
        const level = strengthMap[strength] || 3;
        bars.forEach((bar, index) => {
            if (index < level) {
                bar.className = bar.className.replace('bg-gray-300', 'bg-green-500');
            } else {
                bar.className = bar.className.replace('bg-green-500', 'bg-gray-300');
            }
        });
    }

    // Form AJAX
    document.getElementById('addFleetForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Saving...';

        try {
            const res = await fetch('{{ route("manager.fleet-device.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

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
            alert('Network error (check console)');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Add Fleet';
        }
    });

    // Accept Form Handler
    document.getElementById('acceptForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = e.target.querySelector('button');
        const originalText = btn.textContent;

        btn.disabled = true;
        btn.textContent = 'Accepting...';

        try {
            const res = await fetch(e.target.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (data.success) {
                alert('Task accepted successfully!');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert(data.message || 'Failed to accept task');
                btn.disabled = false;
                btn.textContent = originalText;
            }
        } catch (err) {
            console.error(err);
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.textContent = originalText;
        }
    });

    // Inisialisasi peta (hanya sekali)
    let fleetMap = null;
    let fleetMarker = null;

    function initFleetMap() {
        if (fleetMap) return; // Sudah diinisialisasi

        const mapContainer = document.getElementById('fleetMap');
        if (!mapContainer) return;

        // Buat peta
        fleetMap = L.map('fleetMap').setView([-6.2088, 106.8456], 10); // Default: Jakarta

        // Tambahkan tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(fleetMap);

        // Buat marker kosong
        fleetMarker = L.marker([0, 0], {
            draggable: false,
            title: 'Current Location'
        }).addTo(fleetMap);
        fleetMarker.setOpacity(0); // Sembunyikan dulu
    }

    // Update lokasi peta
    function updateFleetMap(lat, lng, address) {
        if (!fleetMap || !fleetMarker) return;

        if (lat && lng && lat !== '—' && lng !== '—') {
            const latNum = parseFloat(lat);
            const lngNum = parseFloat(lng);
            if (!isNaN(latNum) && !isNaN(lngNum)) {
                fleetMap.setView([latNum, lngNum], 15);
                fleetMarker.setLatLng([latNum, lngNum]);
                fleetMarker.setOpacity(1);
                fleetMarker.bindPopup(
                    `<strong>Current Location</strong><br>${(address && address !== '—') ? address : 'No address available'}`, {
                        maxWidth: 200
                    }
                ).openPopup();
            } else {
                fleetMarker.setOpacity(0);
            }
        } else {
            fleetMarker.setOpacity(0);
        }
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        attachCardListeners();

        // Initialize Leaflet map when DOM is ready
        initFleetMap();
    });
</script>
@endsection