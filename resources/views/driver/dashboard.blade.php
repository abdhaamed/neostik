@extends('driver.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, {{ $driver->name }}!</h1>
    <p class="text-gray-600">Here's what's happening with your shipments today</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Active Shipments -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Active Shipments</p>
                <h3 class="text-3xl font-bold text-blue-600" id="activeShipmentsCount">{{ $stats['active_shipments'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Completed Today -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Completed Today</p>
                <h3 class="text-3xl font-bold text-green-600" id="completedTodayCount">{{ $stats['completed_today'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Pickups -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pending Pickups</p>
                <h3 class="text-3xl font-bold text-orange-600" id="pendingPickupsCount">{{ $stats['pending_pickups'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Driver Profile Summary -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Driver Information</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <p class="text-sm text-gray-500">Driver ID</p>
            <p class="font-medium text-gray-800">{{ $driver->driver_id }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Status</p>
            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                @if($driver->status === 'active') bg-green-100 text-green-800
                @elseif($driver->status === 'inactive') bg-gray-100 text-gray-800
                @else bg-red-100 text-red-800
                @endif">
                {{ ucfirst($driver->status) }}
            </span>
        </div>
        <div>
            <p class="text-sm text-gray-500">Availability</p>
            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                @if($driver->availability === 'available') bg-green-100 text-green-800
                @elseif($driver->availability === 'on_duty') bg-blue-100 text-blue-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst(str_replace('_', ' ', $driver->availability)) }}
            </span>
        </div>
        <div>
            <p class="text-sm text-gray-500">Completed Deliveries</p>
            <p class="font-medium text-gray-800">{{ $driver->completed_deliveries ?? 0 }}</p>
        </div>
    </div>
</div>

<!-- Recent Tasks -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800">Recent Tasks</h2>
        <a href="{{ route('driver.shipments') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
            View All →
        </a>
    </div>

    <div id="recentTasksContainer">
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <p class="text-gray-500">Loading tasks...</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();
        
        // Refresh data every 30 seconds
        setInterval(loadDashboardData, 30000);
    });

    function loadDashboardData() {
        fetch('/driver/dashboard/data', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStats(data.stats);
                updateRecentTasks(data.recentTasks);
            }
        })
        .catch(error => {
            console.error('Error loading dashboard data:', error);
        });
    }

    function updateStats(stats) {
        document.getElementById('activeShipmentsCount').textContent = stats.active_shipments || 0;
        document.getElementById('completedTodayCount').textContent = stats.completed_today || 0;
        document.getElementById('pendingPickupsCount').textContent = stats.pending_pickups || 0;
    }

    function updateRecentTasks(tasks) {
        const container = document.getElementById('recentTasksContainer');
        
        if (!tasks || tasks.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">No tasks assigned yet</p>
                </div>
            `;
            return;
        }

        container.innerHTML = tasks.map(task => {
            const statusColors = {
                'assigned': 'bg-orange-100 text-orange-800',
                'en_route': 'bg-blue-100 text-blue-800',
                'completed': 'bg-green-100 text-green-800',
                'cancelled': 'bg-red-100 text-red-800'
            };
            const statusColor = statusColors[task.status] || 'bg-gray-100 text-gray-800';
            
            return `
                <div class="border border-gray-200 rounded-lg p-4 mb-3 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">Task #${task.task_number}</h3>
                            <p class="text-xs text-gray-500 mt-1">
                                ${task.fleet ? 'Fleet: ' + task.fleet.fleet_id : 'No fleet assigned'}
                            </p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium ${statusColor}">
                            ${task.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 text-sm mb-3">
                        <div>
                            <p class="text-gray-500 text-xs">Origin</p>
                            <p class="text-gray-800 truncate">${task.origin || '—'}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Destination</p>
                            <p class="text-gray-800 truncate">${task.destination || '—'}</p>
                        </div>
                    </div>
                    
                    ${task.cargo_type ? `
                        <p class="text-xs text-gray-600 mb-3">
                            <span class="font-medium">Cargo:</span> ${task.cargo_type}
                            ${task.cargo_volume ? ' • ' + task.cargo_volume : ''}
                        </p>
                    ` : ''}
                    
                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                        <p class="text-xs text-gray-500">${formatDate(task.created_at)}</p>
                        <a href="/driver/tasks/${task.id}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                            View Details →
                        </a>
                    </div>
                </div>
            `;
        }).join('');
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // seconds
        
        if (diff < 60) return 'Just now';
        if (diff < 3600) return Math.floor(diff / 60) + ' minutes ago';
        if (diff < 86400) return Math.floor(diff / 3600) + ' hours ago';
        
        return date.toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric',
            year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined
        });
    }
</script>
@endpush