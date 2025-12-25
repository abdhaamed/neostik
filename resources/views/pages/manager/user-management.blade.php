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

        <main class="flex-1">
            <!-- Status Board Content (Default Active) -->
            <div id="contentStatusboard" class="page-content bg-white p-6 rounded shadow">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Status Board</h2>
                    <div class="flex items-center gap-3">
                        <!-- Search Input -->
                        <div class="relative">
                            <input
                                type="text"
                                id="searchDriver"
                                placeholder="Search Driver"
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                            <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <!-- Filters Button -->
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filters
                        </button>
                        <!-- Export Button -->
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </button>
                        <!-- Add New Driver Button -->
                        <button id="btnAddDriver" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add new Driver
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full" id="driverTable">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">ID Driver</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Name</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Email</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Phone</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Status</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Availability</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Rating</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Deliveries</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="driverTableBody">
                            @forelse($drivers as $driver)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->driver_id }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->email }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->phone }}</td>
                                <td class="py-4 px-4">
                                    <span class="flex items-center gap-2 text-sm">
                                        <span class="w-2 h-2 rounded-full {{ $driver->status === 'active' ? 'bg-green-500' : ($driver->status === 'suspended' ? 'bg-red-500' : 'bg-gray-400') }}"></span>
                                        <span class="text-gray-700 capitalize">{{ $driver->status }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="flex items-center gap-2 text-sm">
                                        <span class="w-2 h-2 rounded-full {{ $driver->availability === 'available' ? 'bg-green-500' : ($driver->availability === 'on_duty' ? 'bg-yellow-500' : 'bg-gray-400') }}"></span>
                                        <span class="text-gray-700 capitalize">{{ str_replace('_', ' ', $driver->availability) }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ number_format($driver->rating, 1) }}/5</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $driver->completed_deliveries }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="editDriver('{{ $driver->id }}')" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="deleteDriver('{{ $driver->id }}', '{{ $driver->name }}')" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-500">No drivers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Assignment Request Panel Content (Hidden by default) -->
            <div id="contentAssignment" class="page-content bg-white rounded shadow hidden">
                <main class="flex-1 overflow-hidden flex">
                    <!-- Left Section - Driver List -->
                    <div class="bg-white border-r border-gray-200 flex flex-col">
                        <!-- Filter & Search -->
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="relative flex-1">
                                    <input type="text" id="searchDriverAssignment" placeholder="Search Driver"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Driver Cards -->
                        <div class="flex-1 overflow-y-auto p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Card 1 - Selected State -->
                                <div class="bg-white rounded-lg border-2 border-orange-400 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer driver-card" data-driver-id="1">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Olivia+Rodrigo&background=6366f1&color=fff" alt="Driver" class="w-8 h-8 rounded-full">
                                            <h4 class="text-gray-800 font-semibold text-sm">Olivia Rodrigo</h4>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Driver ID -->
                                    <p class="text-xs text-gray-500 mb-3">DRV-0829374850</p>
                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-3 gap-2 mb-3">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Delivery</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Task</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Rating</div>
                                            <div class="text-lg font-bold text-gray-800">4/5</div>
                                        </div>
                                    </div>
                                    <!-- Productivity -->
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">Productivity</span>
                                        <span class="font-semibold text-gray-700">0%</span>
                                    </div>
                                </div>

                                <!-- Card 2 -->
                                <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer driver-card" data-driver-id="2">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=10b981&color=fff" alt="Driver" class="w-8 h-8 rounded-full">
                                            <h4 class="text-gray-800 font-semibold text-sm">John Doe</h4>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Driver ID -->
                                    <p class="text-xs text-gray-500 mb-3">DRV-9076327856</p>
                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-3 gap-2 mb-3">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Delivery</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Task</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Rating</div>
                                            <div class="text-lg font-bold text-gray-800">4/5</div>
                                        </div>
                                    </div>
                                    <!-- Productivity -->
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">Productivity</span>
                                        <span class="font-semibold text-gray-700">0%</span>
                                    </div>
                                </div>

                                <!-- Card 3 -->
                                <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer driver-card" data-driver-id="3">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=f59e0b&color=fff" alt="Driver" class="w-8 h-8 rounded-full">
                                            <h4 class="text-gray-800 font-semibold text-sm">Jane Smith</h4>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Driver ID -->
                                    <p class="text-xs text-gray-500 mb-3">DRV-0912347890</p>
                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-3 gap-2 mb-3">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Delivery</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Task</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Rating</div>
                                            <div class="text-lg font-bold text-gray-800">4/5</div>
                                        </div>
                                    </div>
                                    <!-- Productivity -->
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">Productivity</span>
                                        <span class="font-semibold text-gray-700">0%</span>
                                    </div>
                                </div>

                                <!-- Card 4 -->
                                <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer driver-card" data-driver-id="4">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=ef4444&color=fff" alt="Driver" class="w-8 h-8 rounded-full">
                                            <h4 class="text-gray-800 font-semibold text-sm">Michael Brown</h4>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Driver ID -->
                                    <p class="text-xs text-gray-500 mb-3">DRV-0123892178</p>
                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-3 gap-2 mb-3">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Delivery</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Task</div>
                                            <div class="text-lg font-bold text-gray-800">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Rating</div>
                                            <div class="text-lg font-bold text-gray-800">4/5</div>
                                        </div>
                                    </div>
                                    <!-- Productivity -->
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">Productivity</span>
                                        <span class="font-semibold text-gray-700">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section - Task Assignment Form -->
                    <div class="flex-1 bg-gray-50 overflow-y-auto" id="taskFormPanel">
                        <!-- PLACEHOLDER MESSAGE -->
                        <div id="placeholderTaskMessage" class="hidden h-full flex flex-col justify-center items-center text-gray-400">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">Select a driver to assign task</p>
                        </div>

                        <!-- TASK FORM (DEFAULT VISIBLE) -->
                        <div id="taskFormDetail" class="p-6">
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Column - Task Information -->
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Task Information</h3>
                                        <p class="text-sm text-gray-600 mb-4">Add Task For Employee</p>

                                        <!-- Nomor Tugas -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Tugas</label>
                                            <input type="text" placeholder="Nomor Tugas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Tanggal Pengiriman -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengiriman</label>
                                            <div class="relative">
                                                <input type="text" placeholder="Placeholder" class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Asal Pengiriman -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Asal Pengiriman</label>
                                            <textarea placeholder="Enter a description..." rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>

                                        <!-- Tujuan Pengiriman -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan Pengiriman</label>
                                            <textarea placeholder="Enter a description..." rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>

                                        <!-- Jenis Barang -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Barang</label>
                                            <input type="text" placeholder="Placeholder" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Jumlah / Volume Barang -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah / Volume Barang</label>
                                            <input type="text" placeholder="Placeholder" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <!-- Nomor Kendaraan -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kendaraan</label>
                                            <input type="text" placeholder="Placeholder" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Documents & Evidence -->
                                <div class="space-y-6">
                                    <!-- Document Task -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Task</h3>
                                        <p class="text-sm text-gray-600 mb-4">Official shipping documents</p>

                                        <!-- Surat Jalan -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Surat Jalan</label>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                                <input type="file" class="hidden" id="suratJalan">
                                                <label for="suratJalan" class="cursor-pointer">
                                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500">Upload File</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Invoice -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Invoice</label>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                                <input type="file" class="hidden" id="invoice">
                                                <label for="invoice" class="cursor-pointer">
                                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500">Upload File</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Delivery Note -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Note</label>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                                <input type="file" class="hidden" id="deliveryNote">
                                                <label for="deliveryNote" class="cursor-pointer">
                                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500">Upload File</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Evidence Goods -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Evidence Goods</h3>
                                        <p class="text-sm text-gray-600 mb-4">Initial proof before the driver leaves</p>

                                        <!-- Foto Muatan -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Muatan</label>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                                <input type="file" class="hidden" id="fotoMuatan" accept="image/*">
                                                <label for="fotoMuatan" class="cursor-pointer">
                                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500">Upload File</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- QR Code -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">QR Code</label>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                                <input type="file" class="hidden" id="qrCode" accept="image/*">
                                                <label for="qrCode" class="cursor-pointer">
                                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500">Upload File</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Operating Costs -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Operating costs</h3>
                                        <p class="text-sm text-gray-600 mb-4">Initial proof before the driver leaves</p>

                                        <!-- Nominal Uang Jalan -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Uang Jalan</label>
                                            <input type="text" placeholder="Nominal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex justify-end gap-3 pt-4">
                                        <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            Assign Task
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
    </div>

    <!-- Modal Add/Edit Driver -->
    @include('components.modals.driver-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Page switching
            const pageButtons = document.querySelectorAll('.page-button');
            const pageContents = document.querySelectorAll('.page-content');

            pageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetPage = this.getAttribute('data-page');

                    pageButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-600', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-700');
                    });

                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-blue-600', 'text-white');

                    pageContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    const targetId = 'content' + targetPage.charAt(0).toUpperCase() + targetPage.slice(1);
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            // Add Driver Button
            document.getElementById('btnAddDriver').addEventListener('click', function() {
                openDriverModal();
            });

            // Search Driver
            let searchTimeout;
            document.getElementById('searchDriver').addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchDrivers(e.target.value);
                }, 500);
            });
        });

        // Global functions for modal
        let currentDriverId = null;

        function openDriverModal(driverId = null) {
            currentDriverId = driverId;
            const modal = document.getElementById('driverModal');
            const modalTitle = document.getElementById('modalTitle');
            const form = document.getElementById('driverForm');
            const statusField = document.getElementById('statusField');
            const availabilityField = document.getElementById('availabilityField');

            form.reset();

            if (driverId) {
                modalTitle.textContent = 'Edit Driver';
                statusField.classList.remove('hidden');
                availabilityField.classList.remove('hidden');

                // Load driver data via AJAX
                fetch(`/manager/users/${driverId}`)
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            const driver = response.data;
                            // Populate form with driver data
                            form.querySelector('[name="name"]').value = driver.name || '';
                            form.querySelector('[name="email"]').value = driver.email || '';
                            form.querySelector('[name="phone"]').value = driver.phone || '';
                            form.querySelector('[name="license_number"]').value = driver.license_number || '';
                            form.querySelector('[name="vehicle_type"]').value = driver.vehicle_type || '';
                            form.querySelector('[name="vehicle_plate"]').value = driver.vehicle_plate || '';
                            form.querySelector('[name="date_of_birth"]').value = driver.date_of_birth || '';
                            form.querySelector('[name="status"]').value = driver.status || 'active';
                            form.querySelector('[name="availability"]').value = driver.availability || 'available';
                            form.querySelector('[name="address"]').value = driver.address || '';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading driver:', error);
                        alert('Failed to load driver data');
                    });
            } else {
                modalTitle.textContent = 'Add New Driver';
                statusField.classList.add('hidden');
                availabilityField.classList.add('hidden');
            }

            modal.classList.remove('hidden');
        }

        function closeDriverModal() {
            document.getElementById('driverModal').classList.add('hidden');
            currentDriverId = null;
        }

        function saveDriver(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            const url = currentDriverId ?
                `/manager/users/${currentDriverId}` :
                '/manager/users';

            const method = currentDriverId ? 'PUT' : 'POST';

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(response => {
                    if (response.success) {
                        // Show success message
                        let message = response.message;

                        // Show credentials for new driver
                        if (response.credentials) {
                            message += `\n\n📧 Login Credentials:\nEmail: ${response.credentials.email}\nPassword: ${response.credentials.password}\n\n⚠️ Please save these credentials!`;
                        }

                        alert(message);
                        closeDriverModal();
                        location.reload();
                    } else {
                        throw new Error(response.message || 'Save failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving driver: ' + error.message);
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        }

        function editDriver(driverId) {
            openDriverModal(driverId);
        }

        function deleteDriver(driverId, driverName) {
            if (!confirm(`Are you sure you want to delete ${driverName}?`)) return;

            fetch(`/manager/users/${driverId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    alert('Error deleting driver: ' + error.message);
                });
        }

        function searchDrivers(query) {
            if (!query) {
                location.reload();
                return;
            }

            fetch(`/manager/users/search?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        updateDriverTable(response.data);
                    }
                });
        }

        function updateDriverTable(drivers) {
            const tbody = document.getElementById('driverTableBody');

            if (drivers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="py-8 text-center text-gray-500">No drivers found</td></tr>';
                return;
            }

            tbody.innerHTML = drivers.map(driver => `
        <tr class="border-b border-gray-100 hover:bg-gray-50">
            <td class="py-4 px-4 text-sm text-gray-700">${driver.driver_id}</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.name}</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.email}</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.phone}</td>
            <td class="py-4 px-4">
                <span class="flex items-center gap-2 text-sm">
                    <span class="w-2 h-2 rounded-full ${driver.status === 'active' ? 'bg-green-500' : (driver.status === 'suspended' ? 'bg-red-500' : 'bg-gray-400')}"></span>
                    <span class="text-gray-700 capitalize">${driver.status}</span>
                </span>
            </td>
            <td class="py-4 px-4">
                <span class="flex items-center gap-2 text-sm">
                    <span class="w-2 h-2 rounded-full ${driver.availability === 'available' ? 'bg-green-500' : (driver.availability === 'on_duty' ? 'bg-yellow-500' : 'bg-gray-400')}"></span>
                    <span class="text-gray-700 capitalize">${driver.availability.replace('_', ' ')}</span>
                </span>
            </td>
            <td class="py-4 px-4 text-sm text-gray-700">${parseFloat(driver.rating).toFixed(1)}/5</td>
            <td class="py-4 px-4 text-sm text-gray-700">${driver.completed_deliveries}</td>
            <td class="py-4 px-4">
                <div class="flex items-center gap-2">
                    <button onclick="editDriver(${driver.id})" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button onclick="deleteDriver(${driver.id}, '${driver.name}')" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
        }

        function openDriverModal() {
            const modal = document.getElementById('driverModal');
            const box = modal.children[0];

            // tampilkan modal
            modal.classList.remove('hidden');

            // background blur + fade
            modal.classList.add(
                'backdrop-blur-md',
                'bg-black/30',
                'transition-opacity',
                'duration-300',
                'opacity-100'
            );

            // reset awal animasi
            box.classList.add(
                'transition-all',
                'duration-300',
                'ease-out',
                'scale-95',
                'opacity-0'
            );

            requestAnimationFrame(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeDriverModal() {
            const modal = document.getElementById('driverModal');
            const box = modal.children[0];

            // animasi keluar
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove(
                    'backdrop-blur-md',
                    'bg-black/30',
                    'opacity-100'
                );
            }, 300);
        }
    </script>
    @endsection