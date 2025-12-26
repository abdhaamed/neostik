@extends('layouts.app')
@section('content')
<div class="flex h-screen">
    <!-- Left Bar - Always visible (Logo + Hamburger) -->
    @include('components.sidebar.humbergerButton')

    <!-- Overlay - Click outside to close (transparent) -->
    <div id="overlay" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden"></div>

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
        <main class="flex-1 p-10" style="margin-left: 60px;">
            <div class="bg-white p-6 rounded shadow">
                ISI broadcast DI SINI
            </div>
        </main>
    </div>
</div>
<script>

</script>
@endsection