@extends('driver.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-2">Welcome back, {{ $driver->name }}!</h1>
            <p class="text-blue-100">Here's your activity summary for today</p>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Driver Status Badge -->
            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                <span class="text-sm font-medium">Status: </span>
                <span class="font-bold">{{ ucfirst(str_replace('_', ' ', $driver->availability)) }}</span>
            </div>
            <!-- Rating -->
            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                <span class="text-sm font-medium">Rating: </span>
                <span class="font-bold">⭐ {{ number_format($driver->rating, 1) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Active Shipments -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-lg p-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Active Shipments</dt>
                    <dd class="text-3xl font-bold text-gray-900">{{ $stats['active_shipments'] }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Completed Today -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-lg p-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Today</dt>
                    <dd class="text-3xl font-bold text-gray-900">{{ $stats['completed_today'] }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Pending Pickups -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 rounded-lg p-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Pickups</dt>
                    <dd class="text-3xl font-bold text-gray-900">{{ $stats['pending_pickups'] }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Active Shipments (Left - 2 columns) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Active Shipments</h2>
                <a href="{{ route('driver.shipments') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="p-6">
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No active shipments</p>
                    <p class="text-gray-400 text-sm mt-2">Your assigned shipments will appear here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Driver Info Card (Right - 1 column) -->
    <div class="lg:col-span-1">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Driver Profile</h2>
            </div>
            <div class="p-6">
                <!-- Avatar -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-3">
                        {{ $driver->initials }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $driver->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $driver->driver_id }}</p>
                </div>

                <!-- Stats -->
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Deliveries</span>
                        <span class="font-bold text-gray-900">{{ $driver->completed_deliveries }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Rating</span>
                        <span class="font-bold text-gray-900">{{ number_format($driver->rating, 1) }}/5.0</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Completion Rate</span>
                        <span class="font-bold text-green-600">{{ $driver->completion_rate }}%</span>
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <a href="{{ route('driver.profile') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-medium transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Vehicle Info Card -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Vehicle Information</h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-500 text-sm">Type</span>
                        <p class="font-semibold text-gray-900">{{ $driver->vehicle_type ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Plate Number</span>
                        <p class="font-semibold text-gray-900">{{ $driver->vehicle_plate ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">License</span>
                        <p class="font-semibold text-gray-900">{{ $driver->license_number ?? 'Not set' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection