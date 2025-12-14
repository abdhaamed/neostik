@extends('layouts.app')
@section('content')
<div class="flex h-screen">
    <!-- Left Bar - Always visible (Logo + Hamburger) -->
    <div id="leftBar" class="fixed left-0 top-0 h-screen bg-gray-100 border-r border-gray-300 z-50 flex flex-col items-center py-4 px-2 transition-transform duration-300" style="width: 60px;">
        <!-- Logo -->
        <div class="mb-4 w-10 h-10 flex items-center justify-center">
            <!-- Tempat logo Anda di sini -->
            <img src="{{ asset('images/NEOSTIK.png') }}" alt="Logo" class="w-full h-full object-contain">
        </div>
        
        <!-- Hamburger Button -->
        <button onclick="toggleSidebar()" class="p-2 rounded hover:bg-gray-200">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <!-- Overlay - Click outside to close (transparent) -->
    <div id="overlay" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden"></div>
    <!-- Sidebar - Default hidden -->
    <aside id="sidebar" class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
        @include('components.sidebar')
        @include('components.profile')
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-10" style="margin-left: 60px;">
        <div class="bg-white p-6 rounded shadow">
            ISI alert DI SINI
        </div>
    </main>
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