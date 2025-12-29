<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">

        @include('components.sidebar.humbergerButton')

        <!-- Sidebar - Default hidden -->
        <aside id="sidebar" class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
            @include('components.sidebar.sidebar')
            @include('components.sidebar.profile')
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col" style="margin-left: 60px;">
            <header class="px-4 py-2">
                <!-- Header Top with Tabs -->
                @include('components.headerTop.headerTab')
                <!-- Status Badges -->
                @include('components.headerTop.badgeStatus')
            </header>

            <!-- Content with Map and Right Sidebar -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Map Area -->
                @include('components.content-dashboard.dashboard.map')

                <!-- Right Sidebar -->
                <aside class="w-64 bg-white border-l border-gray-200 overflow-y-auto">
                    <!-- Fleets Section -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="mt-3">
                            <input type="text" id="searchFleet" placeholder="Search fleet..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                    </div>

                    <!-- Vehicle List -->
                    <div id="fleetList" class="divide-y divide-gray-200">
                        <!-- Loading State -->
                        <div class="p-4 text-center text-gray-500">
                            <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                            <p class="text-sm">Loading fleets...</p>
                        </div>
                    </div>
                </aside>

                <!-- Fleet Detail Panel - Sliding from Right -->
                <div id="fleetDetail" class="fixed right-0 top-0 h-full w-96 bg-white border-l border-gray-300 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
                    <!-- Header -->
                    <div class="bg-orange-500 text-white p-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="detailFleetId" class="text-lg font-bold">-</h2>
                                <p id="detailStatus" class="text-sm opacity-90">-</p>
                            </div>
                        </div>
                        <button onclick="closeFleetDetail()" class="text-white hover:bg-orange-600 p-2 rounded">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Driver/Task Info -->
                    <div id="driverInfo" class="p-4 border-b border-gray-200 hidden">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <div>
                                <p id="detailDriverName" class="font-bold text-gray-800">-</p>
                                <p id="detailDriverId" class="text-xs text-gray-500">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex border-b border-gray-200">
                        <button onclick="switchTab('overview')" id="tabOverview" class="flex-1 px-4 py-3 text-sm font-medium text-white bg-blue-500 border-b-2 border-blue-500">
                            Overview
                        </button>
                        <button onclick="switchTab('history')" id="tabHistory" class="flex-1 px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            History
                        </button>
                    </div>

                    <!-- Overview Content -->
                    <div id="overviewContent" class="p-4">
                        <!-- Fleet Information -->
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 mb-3">Fleet Information</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fleet ID:</span>
                                    <span id="infoFleetId" class="font-medium text-gray-800">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span id="infoStatus" class="font-medium">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Weight:</span>
                                    <span id="infoWeight" class="font-medium text-gray-800">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Device Information -->
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 mb-3">Device Information</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Connection Status -->
                                <div class="border border-gray-300 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <i class="fas fa-plug text-blue-500"></i>
                                        <span class="text-xs font-semibold text-gray-600">Connection</span>
                                    </div>
                                    <p id="deviceConnection" class="text-sm font-bold text-gray-800">-</p>
                                </div>

                                <!-- Signal Strength -->
                                <div class="border border-gray-300 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <i class="fas fa-signal text-green-500"></i>
                                        <span class="text-xs font-semibold text-gray-600">Signal</span>
                                    </div>
                                    <p id="deviceSignal" class="text-sm font-bold text-gray-800">-</p>
                                </div>

                                <!-- Speed -->
                                <div class="border border-gray-300 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <i class="fas fa-tachometer-alt text-purple-500"></i>
                                        <span class="text-xs font-semibold text-gray-600">Speed</span>
                                    </div>
                                    <p id="deviceSpeed" class="text-sm font-bold text-gray-800">-</p>
                                </div>

                                <!-- Last Update -->
                                <div class="border border-gray-300 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <i class="fas fa-clock text-orange-500"></i>
                                        <span class="text-xs font-semibold text-gray-600">Updated</span>
                                    </div>
                                    <p id="deviceLastUpdate" class="text-xs font-bold text-gray-800">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 mb-2">Current Location</h3>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                                    <div class="flex-1">
                                        <p id="deviceAddress" class="text-sm text-gray-700">-</p>
                                        <p id="deviceCoordinates" class="text-xs text-gray-500 mt-1">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Task Information (if assigned) -->
                        <div id="taskInfo" class="mb-4 hidden">
                            <h3 class="font-bold text-gray-800 mb-3">Task Information</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Task Number:</span>
                                    <span id="taskNumber" class="font-medium text-gray-800">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Origin:</span>
                                    <span id="taskOrigin" class="font-medium text-gray-800">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Destination:</span>
                                    <span id="taskDestination" class="font-medium text-gray-800">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Cargo Type:</span>
                                    <span id="taskCargoType" class="font-medium text-gray-800">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- History Content (Hidden by default) -->
                    <div id="historyContent" class="p-4 hidden">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-gray-800">Device History</h3>
                            <button onclick="loadDeviceHistory()" class="text-xs text-blue-500 hover:text-blue-700">
                                <i class="fas fa-sync-alt mr-1"></i>Refresh
                            </button>
                        </div>

                        <!-- History Table -->
                        <div id="historyList" class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="w-full text-xs">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-600">Time</th>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-600">Event</th>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="historyTableBody" class="divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="3" class="px-3 py-4 text-center text-gray-500">
                                            <i class="fas fa-spinner fa-spin"></i> Loading...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Overlay for Detail Panel -->
                <div id="detailOverlay" onclick="closeFleetDetail()" class="fixed inset-0 bg-transparent z-40 hidden"></div>
            </div>
        </div>
    </div>

    <script>
        let currentFleetData = null;

        // Load fleets on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadFleets();

            // Search functionality
            document.getElementById('searchFleet').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const fleetItems = document.querySelectorAll('.fleet-item');
                
                fleetItems.forEach(item => {
                    const fleetId = item.dataset.fleetId.toLowerCase();
                    const status = item.dataset.status.toLowerCase();
                    if (fleetId.includes(searchTerm) || status.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Load all fleets from backend
        function loadFleets() {
            fetch('/api/fleets')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderFleetList(data.fleets);
                    }
                })
                .catch(error => {
                    console.error('Error loading fleets:', error);
                    document.getElementById('fleetList').innerHTML = `
                        <div class="p-4 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p class="text-sm">Failed to load fleets</p>
                        </div>
                    `;
                });
        }

        // Render fleet list
        function renderFleetList(fleets) {
            const fleetList = document.getElementById('fleetList');
            
            if (fleets.length === 0) {
                fleetList.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        <i class="fas fa-truck text-3xl mb-2"></i>
                        <p class="text-sm">No fleets available</p>
                    </div>
                `;
                return;
            }

            fleetList.innerHTML = fleets.map(fleet => {
                const statusColors = {
                    'Unassigned': 'bg-gray-100 text-gray-700',
                    'Assigned': 'bg-blue-100 text-blue-700',
                    'En Route': 'bg-green-100 text-green-700',
                    'Completed': 'bg-purple-100 text-purple-700'
                };

                const statusColor = statusColors[fleet.status] || 'bg-gray-100 text-gray-700';

                return `
                    <div class="fleet-item p-4 hover:bg-gray-50 cursor-pointer transition-colors" 
                         data-fleet-id="${fleet.fleet_id}"
                         data-status="${fleet.status}"
                         onclick='handleFleetClick(${JSON.stringify(fleet).replace(/'/g, "&#39;")})'>
                        <div class="flex items-start space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-gray-800 truncate">${fleet.fleet_id}</h4>
                                    <span class="px-2 py-0.5 ${statusColor} text-xs rounded-full flex-shrink-0">${fleet.status}</span>
                                </div>
                                <p class="text-xs text-gray-500">Weight: ${fleet.weight || 'N/A'} kg</p>
                                ${fleet.device ? `<p class="text-xs text-gray-400 mt-1">Device: ${fleet.device.device_id}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Handle fleet click
        function handleFleetClick(fleet) {
            currentFleetData = fleet;
            showFleetDetail(fleet);
        }

        // Show fleet detail panel
        function showFleetDetail(fleet) {
            // Update header
            document.getElementById('detailFleetId').textContent = fleet.fleet_id;
            document.getElementById('detailStatus').textContent = fleet.status;

            // Update fleet info
            document.getElementById('infoFleetId').textContent = fleet.fleet_id;
            document.getElementById('infoStatus').innerHTML = `<span class="px-2 py-1 rounded text-xs ${getStatusColor(fleet.status)}">${fleet.status}</span>`;
            document.getElementById('infoWeight').textContent = fleet.weight ? `${fleet.weight} kg` : 'N/A';

            // Update device info
            if (fleet.device) {
                document.getElementById('deviceConnection').textContent = fleet.device.connection_status || '-';
                document.getElementById('deviceSignal').textContent = fleet.device.signal_strength || '-';
                document.getElementById('deviceSpeed').textContent = fleet.device.speed ? `${fleet.device.speed} km/h` : '0 km/h';
                document.getElementById('deviceLastUpdate').textContent = formatDateTime(fleet.device.last_update);
                document.getElementById('deviceAddress').textContent = fleet.device.address || 'No address available';
                document.getElementById('deviceCoordinates').textContent = fleet.device.latitude && fleet.device.longitude 
                    ? `${fleet.device.latitude}, ${fleet.device.longitude}` 
                    : 'No coordinates';
            } else {
                document.getElementById('deviceConnection').textContent = 'No Device';
                document.getElementById('deviceSignal').textContent = '-';
                document.getElementById('deviceSpeed').textContent = '-';
                document.getElementById('deviceLastUpdate').textContent = '-';
                document.getElementById('deviceAddress').textContent = 'No device attached';
                document.getElementById('deviceCoordinates').textContent = '-';
            }

            // Show/hide driver info and task info based on status
            if (fleet.status === 'Assigned' || fleet.status === 'En Route' || fleet.status === 'Completed') {
                loadTaskInfo(fleet.id);
            } else {
                document.getElementById('driverInfo').classList.add('hidden');
                document.getElementById('taskInfo').classList.add('hidden');
            }

            // Show panel
            document.getElementById('fleetDetail').classList.remove('translate-x-full');
            document.getElementById('detailOverlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Load task information
        function loadTaskInfo(fleetId) {
            fetch(`/api/fleets/${fleetId}/task`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.task) {
                        const task = data.task;
                        
                        // Show driver info
                        document.getElementById('driverInfo').classList.remove('hidden');
                        document.getElementById('detailDriverName').textContent = task.driver?.name || '-';
                        document.getElementById('detailDriverId').textContent = task.driver?.driver_id || '-';

                        // Show task info
                        document.getElementById('taskInfo').classList.remove('hidden');
                        document.getElementById('taskNumber').textContent = task.task_number || '-';
                        document.getElementById('taskOrigin').textContent = task.origin || '-';
                        document.getElementById('taskDestination').textContent = task.destination || '-';
                        document.getElementById('taskCargoType').textContent = task.cargo_type || '-';
                    }
                })
                .catch(error => console.error('Error loading task:', error));
        }

        // Load device history
        function loadDeviceHistory() {
            if (!currentFleetData || !currentFleetData.device) {
                document.getElementById('historyTableBody').innerHTML = `
                    <tr><td colspan="3" class="px-3 py-4 text-center text-gray-500">No device attached</td></tr>
                `;
                return;
            }

            fetch(`/manager/device/${currentFleetData.device.id}/histories`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.histories.length > 0) {
                        renderHistory(data.histories);
                    } else {
                        document.getElementById('historyTableBody').innerHTML = `
                            <tr><td colspan="3" class="px-3 py-4 text-center text-gray-500">No history available</td></tr>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading history:', error);
                    document.getElementById('historyTableBody').innerHTML = `
                        <tr><td colspan="3" class="px-3 py-4 text-center text-red-500">Failed to load history</td></tr>
                    `;
                });
        }

        // Render history table
        function renderHistory(histories) {
            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = histories.map(history => `
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 text-gray-700">${formatDateTime(history.event_timestamp)}</td>
                    <td class="px-3 py-2 text-gray-700">${history.event_type}</td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-0.5 rounded text-xs ${getStatusColor(history.status)}">${history.status}</span>
                    </td>
                </tr>
            `).join('');
        }

        // Close fleet detail
        function closeFleetDetail() {
            document.getElementById('fleetDetail').classList.add('translate-x-full');
            document.getElementById('detailOverlay').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentFleetData = null;
        }

        // Switch tab
        function switchTab(tabName) {
            const overviewTab = document.getElementById('tabOverview');
            const historyTab = document.getElementById('tabHistory');
            const overviewContent = document.getElementById('overviewContent');
            const historyContent = document.getElementById('historyContent');

            if (tabName === 'overview') {
                overviewTab.classList.add('text-white', 'bg-blue-500', 'border-blue-500');
                overviewTab.classList.remove('text-gray-600');
                historyTab.classList.remove('text-white', 'bg-blue-500', 'border-blue-500');
                historyTab.classList.add('text-gray-600');
                overviewContent.classList.remove('hidden');
                historyContent.classList.add('hidden');
            } else if (tabName === 'history') {
                historyTab.classList.add('text-white', 'bg-blue-500', 'border-blue-500');
                historyTab.classList.remove('text-gray-600');
                overviewTab.classList.remove('text-white', 'bg-blue-500', 'border-blue-500');
                overviewTab.classList.add('text-gray-600');
                historyContent.classList.remove('hidden');
                overviewContent.classList.add('hidden');
                loadDeviceHistory();
            }
        }

        // Utility functions
        function getStatusColor(status) {
            const colors = {
                'Unassigned': 'bg-gray-100 text-gray-700',
                'Assigned': 'bg-blue-100 text-blue-700',
                'En Route': 'bg-green-100 text-green-700',
                'Completed': 'bg-purple-100 text-purple-700',
                'Connected': 'bg-green-100 text-green-700',
                'Disconnected': 'bg-red-100 text-red-700',
                'Idle': 'bg-yellow-100 text-yellow-700',
                'Active': 'bg-green-100 text-green-700',
                'Stopped': 'bg-gray-100 text-gray-700'
            };
            return colors[status] || 'bg-gray-100 text-gray-700';
        }

        function formatDateTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Close with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const detailPanel = document.getElementById('fleetDetail');
                if (!detailPanel.classList.contains('translate-x-full')) {
                    closeFleetDetail();
                }
            }
        });
    </script>
</body>

</html>