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
                @include('components.pageContent.dashboard.map')

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

                        @foreach($fleets as $fleet)
                        <div
                            onclick="showFleetDetail('{{ $fleet->license_plate }}', '{{ $fleet->category?->name ?? `Unknown` }}', 'Driver Name Placeholder')"
                            class="p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <!-- Container gambar dengan fallback SVG -->
                                <div class="w-12 h-12 rounded flex items-center justify-center flex-shrink-0 overflow-hidden bg-gray-200">
                                    @if($fleet->image)
                                    <img
                                        src="{{ asset('storage/' . $fleet->image) }}"
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
                        @endforeach


                    </div>

                </aside>

                <!-- Fleet Detail Panel - Sliding from Right -->
                @isset($selectedFleet)
                @include('components.pageContent.dashboard.fleet-detail-panel', ['fleet' => $selectedFleet])
                @else
                @include('components.pageContent.dashboard.fleet-detail-panel', ['fleet' => $fleets->first() ?? new \App\Models\Fleet])
                @endif

                <!-- Overlay for Detail Panel -->
                <div id="detailOverlay" onclick="closeFleetDetail()" class="fixed inset-0 bg-transparent z-40 hidden"></div>
            </div>
        </div>
    </div>

    <script>
        // Fleet detail functions
        function showFleetDetail(plateNumber, cargo, driverName) {
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