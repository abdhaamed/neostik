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
                @include('components.pageContent.fleetDevice.filterListFleet')
                <!-- Fleet Cards -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    @include('components.pageContent.fleetDevice.cardFleet')
                </div>
            </div>
            <!-- Right Section - Details -->
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
                    @include('components.pageContent.fleetDevice.detailFleetDevice')
                </div>

            </div>

        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        console.log('Tab Buttons:', tabButtons.length); // Debug
        console.log('Tab Contents:', tabContents.length); // Debug

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                console.log('Clicked tab:', targetTab); // Debug

                // Remove active state dari semua tabs
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                    btn.classList.add('text-gray-600');
                });

                // Add active state ke tab yang diklik
                this.classList.remove('text-gray-600');
                this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');

                // Hide semua content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show content yang sesuai
                const targetId = 'content' + targetTab.charAt(0).toUpperCase() + targetTab.slice(1);
                console.log('Target ID:', targetId); // Debug

                const targetContent = document.getElementById(targetId);
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                    console.log('Content shown:', targetId); // Debug
                } else {
                    console.error('Content not found:', targetId); // Debug
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        // =============================
        // CARD CLICK HANDLER
        // =============================
        const cards = document.querySelectorAll('.fleet-card');
        const placeholder = document.getElementById('placeholderMessage');
        const detail = document.getElementById('realDetail');

        cards.forEach(card => {
            card.addEventListener('click', function() {

                const fleetId = this.getAttribute('data-fleet-id');

                // Show detail panel
                placeholder.classList.add('hidden');
                detail.classList.remove('hidden');

                // === UPDATE FLEET HEADER ===
                const fleetLabel = document.querySelector('[data-label="fleetId"]');
                if (fleetLabel) fleetLabel.textContent = fleetId;

                // === SIMULASI DEVICE DATA (nanti bisa diganti AJAX) ===
                const deviceData = {
                    deviceId: "GPS-" + fleetId,
                    deviceImei: "86217005" + Math.floor(Math.random() * 900000 + 100000),
                    deviceSim: "+62 812-" + Math.floor(Math.random() * 9000 + 1000) + "-" + Math.floor(Math.random() * 9000 + 1000),
                    deviceStatus: "Connected",
                    deviceUpdate: "Just now",
                    deviceSignal: "Strong",
                    deviceLat: "-6.40248" + Math.floor(Math.random() * 10),
                    deviceLng: "106.79424" + Math.floor(Math.random() * 10),
                    deviceSpeed: Math.floor(Math.random() * 80) + " km/h",
                    deviceAddress: "Auto-generated location"
                };

                // === MASUKKAN KE HTML ===
                for (const label in deviceData) {
                    const el = document.querySelector(`[data-label="${label}"]`);
                    if (el) el.textContent = deviceData[label];
                }

            });
        });


    });
</script>
@endsection