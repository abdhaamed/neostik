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

            <!-- Breadcrumb and Action Buttons -->
            <div class="flex items-center justify-between m-6">
                <p class="text-sm text-gray-800">Driver Management / Status Board</p>
                <div class="flex items-center gap-3">
                    <!-- Driver Overview Button -->
                    <button class="page-button px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm transition-colors" data-page="statusboard">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Driver Overview
                    </button>
                    <!-- Assignment Request Panel Button -->
                    <button class="page-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 flex items-center gap-2 text-sm transition-colors" data-page="assignment">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Assignment Request Panel
                    </button>
                </div>
            </div>
        </header>
        <main class="flex-1 px-10">

            <!-- Status Board Content (Default Active) -->
            <div id="contentStatusboard" class="page-content bg-white p-6 rounded shadow">
                @include('components.pageContent.userManagement.dataUser')
            </div>

            <!-- Assignment Request Panel Content (Hidden by default) -->
            <div id="contentAssignment" class="page-content bg-white p-6 rounded shadow hidden">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Assignment Request Panel</h2>
                <p class="text-gray-600">Content untuk Assignment Request Panel akan ditampilkan di sini.</p>
                <!-- Tambahkan konten Assignment Request Panel di sini -->
            </div>
        </main>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Page switching untuk Driver Overview dan Assignment Request Panel
        const pageButtons = document.querySelectorAll('.page-button');
        const pageContents = document.querySelectorAll('.page-content');

        console.log('Page Buttons:', pageButtons.length); // Debug
        console.log('Page Contents:', pageContents.length); // Debug

        pageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetPage = this.getAttribute('data-page');
                console.log('Clicked page:', targetPage); // Debug

                // Remove active state dari semua buttons
                pageButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });

                // Add active state ke button yang diklik
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-blue-600', 'text-white');

                // Hide semua content
                pageContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show content yang sesuai
                const targetId = 'content' + targetPage.charAt(0).toUpperCase() + targetPage.slice(1);
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