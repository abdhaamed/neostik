<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                @include('components.headerTop.badgeStatus', ['statistics' => $statistics])
            </header>

            <!-- Content with Map and Right Sidebar -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Map Area -->
                @include('components.pageContent.dashboard.map')

                <!-- Right Sidebar -->
                <aside class="w-64 bg-white border-l border-gray-200 overflow-y-auto">
                    <!-- Fleets Section -->
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-3">Fleets</h3>
                        
                        <!-- Fleet Category Filters -->
                        <div class="flex flex-wrap gap-2">
                            <button onclick="filterByCategory('')" 
                                    class="category-filter px-3 py-1 bg-blue-500 text-white rounded-full text-sm hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300"
                                    data-category="">
                                All
                            </button>
                            @foreach($fleetCategories as $category)
                            <button onclick="filterByCategory('{{ $category->id }}')" 
                                    class="category-filter px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 focus:ring-2 focus:ring-blue-500 transition duration-300"
                                    data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                            @endforeach
                        </div>

                        <!-- Search Input -->
                        <div class="mt-3">
                            <input type="text" 
                                   id="searchFleet" 
                                   placeholder="Search" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                    </div>

                    <!-- Vehicle List -->
                    <div id="fleetList" class="divide-y divide-gray-200">
                        @forelse($fleets as $fleet)
                        <div data-fleet-id="{{ $fleet->id }}"
                             data-category="{{ $fleet->category_id ?? '' }}"
                             data-plate="{{ strtolower($fleet->license_plate) }}"
                             onclick="loadFleetDetail({{ $fleet->id }})"
                             class="fleet-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <!-- Container gambar dengan fallback SVG -->
                                <div class="w-12 h-12 rounded flex items-center justify-center flex-shrink-0 overflow-hidden bg-gray-200">
                                    @if($fleet->image)
                                    <img src="{{ asset('storage/' . $fleet->image) }}"
                                         alt="{{ $fleet->license_plate }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.parentNode.innerHTML=`<svg class='w-8 h-8 text-gray-400' fill='currentColor' viewBox='0 0 24 24'><path d='M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z'/></svg>`">
                                    @else
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                    </svg>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-gray-800">{{ $fleet->license_plate }}</h4>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $fleet->category?->name ?? 'No Category' }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                            </svg>
                            <p class="font-medium">No fleets available</p>
                            <p class="text-sm mt-1">Add fleets from Fleet Management</p>
                        </div>
                        @endforelse
                    </div>
                </aside>

                <!-- Fleet Detail Panel - Sliding from Right -->
                @include('components.pageContent.dashboard.fleet-detail-panel', ['fleet' => $selectedFleet ?? $fleets->first() ?? new \App\Models\Fleet])

                <!-- Overlay for Detail Panel -->
                <div id="detailOverlay" onclick="closeFleetDetail()" class="fixed inset-0 bg-transparent z-40 hidden"></div>
            </div>
        </div>
    </div>

    <script>
        // CSRF Token Setup for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fleet Detail Functions
        function loadFleetDetail(fleetId) {
            const detailPanel = document.getElementById('fleetDetail');
            const detailOverlay = document.getElementById('detailOverlay');

            // Show loading state
            detailPanel.innerHTML = '<div class="p-8 text-center"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div><p class="mt-4 text-gray-500">Loading fleet details...</p></div>';
            
            // Show panel
            detailPanel.classList.remove('translate-x-full');
            detailOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Fetch fleet detail via AJAX
            fetch(`/dashboard/fleet/${fleetId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateFleetDetailPanel(data.data);
                } else {
                    showError('Failed to load fleet details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('An error occurred while loading fleet details');
            });
        }

        function updateFleetDetailPanel(data) {
            const fleet = data.fleet;
            const driver = data.driver;
            const latestGps = data.latest_gps;
            const activeTask = data.active_task;
            const deviceStatus = data.device_status;

            // Build the detail panel HTML (sesuai dengan fleet-detail-panel.blade.php)
            const panelHTML = `
                <!-- Header -->
                <div class="bg-orange-500 text-white p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div>
                            <h2 id="detailPlateNumber" class="text-lg font-bold">${fleet.license_plate}</h2>
                            <p id="detailCargo" class="text-sm opacity-90">${fleet.category?.name ?? 'No Category'}</p>
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
                            ${driver?.profile_photo_path 
                                ? `<img src="/storage/${driver.profile_photo_path}" alt="${driver.name}" class="w-6 h-6 rounded-full object-cover">`
                                : driver
                                    ? `<span class="text-lg font-bold text-gray-600">${driver.name.charAt(0).toUpperCase()}</span>`
                                    : `<svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg>`
                            }
                        </div>
                        <div>
                            <p id="detailDriverName" class="font-bold text-gray-800">${driver?.name ?? 'No Driver Assigned'}</p>
                            <p class="text-xs text-gray-500">${driver?.email ?? '—'}</p>
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
                    </div>

                    <!-- Info Cards Grid -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <!-- Speed -->
                        <div class="border border-gray-300 rounded-lg p-3">
                            <div class="flex items-center space-x-2 mb-1">
                                <i class="fas fa-tachometer-alt text-blue-500 w-5 h-5"></i>
                                <span class="text-xs font-semibold text-gray-600">Speed</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">${latestGps?.speed ?? 0} km/h</p>
                        </div>

                        <!-- Fuel -->
                        <div class="border border-gray-300 rounded-lg p-3">
                            <div class="flex items-center space-x-2 mb-1">
                                <i class="fas fa-gas-pump text-green-500 w-5 h-5"></i>
                                <span class="text-xs font-semibold text-gray-600">Fuel</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">—</p>
                        </div>

                        <!-- Power -->
                        <div class="border border-gray-300 rounded-lg p-3">
                            <div class="flex items-center space-x-2 mb-1">
                                <i class="fas fa-bolt text-yellow-500 w-5 h-5"></i>
                                <span class="text-xs font-semibold text-gray-600">Power</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">—</p>
                        </div>

                        <!-- Temperature -->
                        <div class="border border-gray-300 rounded-lg p-3">
                            <div class="flex items-center space-x-2 mb-1">
                                <i class="fas fa-temperature-high text-red-500 w-5 h-5"></i>
                                <span class="text-xs font-semibold text-gray-600">Temperature</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">—</p>
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
                                    ${latestGps ? `
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-700">${latestGps.timestamp ? new Date(latestGps.timestamp).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '—'}</td>
                                        <td class="px-3 py-2 text-gray-700">${latestGps.address || 'Unknown location'}</td>
                                    </tr>
                                    ` : `
                                    <tr>
                                        <td colspan="2" class="px-3 py-2 text-gray-500 text-center">No GPS data available</td>
                                    </tr>
                                    `}
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
            `;

            document.getElementById('fleetDetail').innerHTML = panelHTML;
        }

        function closeFleetDetail() {
            const detailPanel = document.getElementById('fleetDetail');
            const detailOverlay = document.getElementById('detailOverlay');

            detailPanel.classList.add('translate-x-full');
            detailOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function showError(message) {
            const detailPanel = document.getElementById('fleetDetail');
            detailPanel.innerHTML = `
                <div class="p-8 text-center">
                    <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <p class="text-gray-600 font-medium">${message}</p>
                    <button onclick="closeFleetDetail()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Close</button>
                </div>
            `;
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

        // Filter by Category
        function filterByCategory(categoryId) {
            const fleetItems = document.querySelectorAll('.fleet-item');
            const categoryButtons = document.querySelectorAll('.category-filter');

            // Update button styles
            categoryButtons.forEach(btn => {
                if (btn.dataset.category === categoryId) {
                    btn.classList.remove('bg-gray-100', 'text-gray-700');
                    btn.classList.add('bg-blue-500', 'text-white');
                } else {
                    btn.classList.remove('bg-blue-500', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                }
            });

            // Filter fleet items
            fleetItems.forEach(item => {
                if (categoryId === '' || item.dataset.category === categoryId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Search Fleet
        document.getElementById('searchFleet')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const fleetItems = document.querySelectorAll('.fleet-item');

            fleetItems.forEach(item => {
                const plateNumber = item.dataset.plate;
                if (plateNumber.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

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