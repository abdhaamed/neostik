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
    <div class="flex-1 flex flex-col" style="margin-left: 60px;">
        <header class="px-4 py-2">
            <!-- Header Top with Tabs -->
            @include('components.headerTop.headerTab')
            <!-- Status Badges -->
            @include('components.headerTop.badgeStatus')
        </header>
        <!-- Main Content -->
        <main class="flex-1 p-10" style="margin-left: 60px;">
            <div class="bg-white p-6 rounded shadow">
                ISI Route DI SINI
            </div>
        </main>
    </div>
</div>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const leftBar = document.getElementById('leftBar');

        sidebar.classList.toggle('-translate-x-full');

        if (sidebar.classList.contains('-translate-x-full')) {
            // Sidebar closed
            overlay.classList.add('hidden');
            localStorage.setItem('sidebarOpen', 'false');
        } else {
            // Sidebar open - hide left bar
            leftBar.style.transform = 'translateX(-100%)';
            overlay.classList.remove('hidden');
            localStorage.setItem('sidebarOpen', 'true');
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const leftBar = document.getElementById('leftBar');

        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        localStorage.setItem('sidebarOpen', 'false');

        // Show left bar with animation
        setTimeout(() => {
            leftBar.style.transform = 'translateX(0)';
        }, 300);
    }

    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarOpen = localStorage.getItem('sidebarOpen');

        if (sidebarOpen === 'true') {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const leftBar = document.getElementById('leftBar');

            sidebar.classList.remove('-translate-x-full');
            leftBar.style.transform = 'translateX(-100%)';
            overlay.classList.remove('hidden');
        }
    });
</script>
@endsection