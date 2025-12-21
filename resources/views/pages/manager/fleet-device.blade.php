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
            <div class="flex-1 bg-gray-50 overflow-y-auto">
                @include('components.pageContent.fleetDevice.detailFleetDevice')
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
</script>
@endsection