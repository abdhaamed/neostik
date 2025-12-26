<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
                        <h3 class="font-bold text-gray-800 mb-3">Fleets</h3>
                        <div class="flex flex-wrap gap-2">
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300">
                                Small Box
                            </button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300">
                                Curtain Side
                            </button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300">
                                Box Trailer
                            </button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300">
                                Pickup
                            </button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300">
                                Middle Box
                            </button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300">
                                Container Box
                            </button>
                        </div>
                        <div class="mt-3">
                            <input type="text" placeholder="Search" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                    </div>

                    <!-- Vehicle List -->
                    <div class="divide-y divide-gray-200">

                        <!-- Vehicle Item 1 -->
                        <div onclick="handleVehicleClick('B 7832 POM', 'Carrying Chemical', 'Olivia Rodrigo', -6.2088, 106.8456)" class="p-4 hover:bg-gray-50 cursor-pointer transition-colors">
                            <div class="flex items-start space-x-3">
                                <!-- Truck Icon -->
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="font-bold text-gray-800 truncate">B 7832 POM</h4>
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full flex-shrink-0">Active</span>
                                    </div>
                                    <p class="text-xs text-gray-500 truncate">Carrying Chemical</p>
                                    <p class="text-xs text-gray-400 mt-1">Driver: Olivia Rodrigo</p>
                                </div>
                            </div>
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
                                <h2 id="detailPlateNumber" class="text-lg font-bold">B 7832 POM</h2>
                                <p id="detailCargo" class="text-sm opacity-90">Carry Chemicals</p>
                            </div>
                        </div>
                        <button onclick="closeFleetDetail()" class="text-white hover:bg-orange-600 p-2 rounded">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Driver Info -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <div>
                                <p id="detailDriverName" class="font-bold text-gray-800">Olivia Rodrigo</p>
                                <p class="text-xs text-gray-500">812897NWN5318891</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex border-b border-gray-200">
                        <button onclick="switchTab('overview')" id="tabOverview" class="flex-1 px-4 py-3 text-sm font-medium text-white bg-blue-500 border-b-2 border-blue-500">
                            Overview
                        </button>
                        <button onclick="switchTab('playback')" id="tabPlayback" class="flex-1 px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            Playback
                        </button>
                    </div>

                    <!-- Overview Content -->
                    <div id="overviewContent" class="p-4">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800">Object Information</h3>
                            <button class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 flex items-center space-x-1">
                                <span>Refresh</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>

                        <!-- Info Cards Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <!-- Speed -->
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex items-center space-x-2 mb-1">
                                    <i class="fas fa-tachometer-alt text-blue-500 w-5 h-5"></i>
                                    <span class="text-xs font-semibold text-gray-600">Speed</span>
                                </div>
                                <p class="text-lg font-bold text-gray-800">22 km/h</p>
                            </div>

                            <!-- Fuel -->
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex items-center space-x-2 mb-1">
                                    <i class="fas fa-gas-pump text-green-500 w-5 h-5"></i>
                                    <span class="text-xs font-semibold text-gray-600">Fuel</span>
                                </div>
                                <p class="text-lg font-bold text-gray-800">50 L</p>
                            </div>

                            <!-- Power -->
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex items-center space-x-2 mb-1">
                                    <i class="fas fa-bolt text-yellow-500 w-5 h-5"></i>
                                    <span class="text-xs font-semibold text-gray-600">Power</span>
                                </div>
                                <p class="text-lg font-bold text-gray-800">4V</p>
                            </div>

                            <!-- Temperature -->
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex items-center space-x-2 mb-1">
                                    <i class="fas fa-temperature-high text-red-500 w-5 h-5"></i>
                                    <span class="text-xs font-semibold text-gray-600">Temperature</span>
                                </div>
                                <p class="text-lg font-bold text-gray-800">84 Celsius</p>
                            </div>
                        </div>
                        <!-- Logs Section -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold text-gray-800">Logs</h3>
                                <button class="text-xs text-gray-500 hover:text-gray-700 flex items-center space-x-1">
                                    <span>Filters</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Logs Table -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <table class="w-full text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Last Update</th>
                                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Address</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-700">12-11-2025 10:20</td>
                                            <td class="px-3 py-2 text-gray-700">Jalan Gendog Panjang, Jakarta Utara</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-700">12-11-2025 10:30</td>
                                            <td class="px-3 py-2 text-gray-700">Jalan Pemuda, Jakarta Utara</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-700">12-11-2025 10:40</td>
                                            <td class="px-3 py-2 text-gray-700">Jalan Pahlawan 1, Jakarta Utara</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-700">12-11-2025 10:50</td>
                                            <td class="px-3 py-2 text-gray-700">Jalan Pahlawan 2, Jakarta Utara</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-700">12-11-2025 11:00</td>
                                            <td class="px-3 py-2 text-gray-700">Jalan Pahlawan 3, Jakarta Utara</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Playback Content (Hidden by default) -->
                    <div id="playbackContent" class="p-4 hidden">
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            <p class="text-lg font-medium">Playback Feature</p>
                            <p class="text-sm mt-2">Track history and route playback will be displayed here</p>
                        </div>
                    </div>
                </div>

                <!-- Overlay for Detail Panel -->
                <div id="detailOverlay" onclick="closeFleetDetail()" class="fixed inset-0 bg-transparent z-40 hidden"></div>
            </div>
        </div>
    </div>

    <script>
        // Fleet detail functions - Updated to work with tabs
        function showFleetDetail(plateNumber, cargo, driverName, latitude = null, longitude = null) {
            const detailPanel = document.getElementById('fleetDetail');
            const detailOverlay = document.getElementById('detailOverlay');

            // Update content
            document.getElementById('detailPlateNumber').textContent = plateNumber;
            document.getElementById('detailCargo').textContent = cargo;
            document.getElementById('detailDriverName').textContent = driverName;

            // Show panel with slide animation
            detailPanel.classList.remove('translate-x-full');
            detailOverlay.classList.remove('hidden');

            // Prevent body scroll when panel is open
            document.body.style.overflow = 'hidden';

            // TODO: Navigate to coordinates on map
            if (latitude && longitude) {
                console.log(`Showing vehicle at: ${latitude}, ${longitude}`);
                // navigateToCoordinates(latitude, longitude);
            }
        }

        function closeFleetDetail() {
            const detailPanel = document.getElementById('fleetDetail');
            const detailOverlay = document.getElementById('detailOverlay');

            // Hide panel with slide animation
            detailPanel.classList.add('translate-x-full');
            detailOverlay.classList.add('hidden');

            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // UPDATED: Vehicle item click handler with tab creation
        function handleVehicleClick(plateNumber, cargo, driverName, latitude = null, longitude = null) {
            // Create or switch to tab
            createVehicleTab(plateNumber, cargo, driverName, latitude, longitude);

            // Show fleet detail
            showFleetDetail(plateNumber, cargo, driverName, latitude, longitude);
        }

        // Tab switching function
        function switchTab(tabName) {
            const overviewTab = document.getElementById('tabOverview');
            const playbackTab = document.getElementById('tabPlayback');
            const overviewContent = document.getElementById('overviewContent');
            const playbackContent = document.getElementById('playbackContent');

            if (tabName === 'overview') {
                overviewTab.classList.add('text-white', 'bg-blue-500', 'border-blue-500');
                overviewTab.classList.remove('text-gray-600');

                playbackTab.classList.remove('text-white', 'bg-blue-500', 'border-blue-500');
                playbackTab.classList.add('text-gray-600');

                overviewContent.classList.remove('hidden');
                playbackContent.classList.add('hidden');
            } else if (tabName === 'playback') {
                playbackTab.classList.add('text-white', 'bg-blue-500', 'border-blue-500');
                playbackTab.classList.remove('text-gray-600');

                overviewTab.classList.remove('text-white', 'bg-blue-500', 'border-blue-500');
                overviewTab.classList.add('text-gray-600');

                playbackContent.classList.remove('hidden');
                overviewContent.classList.add('hidden');
            }
        }

        // Close detail panel with Escape key
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