@extends('layouts.app')

@section('content')
<div class="flex h-screen">

    <!-- Left Bar -->
    @include('components.sidebar.humbergerButton')

    <!-- Sidebar -->
    <aside id="sidebar"
        class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
        @include('components.sidebar.sidebar')
        @include('components.sidebar.profile')
    </aside>

    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col" style="margin-left: 60px;">

        <!-- Header -->
        <header class="px-4 py-2">
            @include('components.headerTop.headerTab')
            @include('components.headerTop.badgeStatus')
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Page Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Route History</h1>
                        <p class="text-gray-600 mt-1">
                            Track fleet assignments and task completion history
                        </p>
                    </div>

                    <!-- ✅ Hapus tombol export (tidak ada di controller) -->
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Fleet</label>
                            <select id="fleetFilter" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">All Fleets</option>
                                @foreach($fleets as $fleet)
                                    <option value="{{ $fleet->id }}">{{ $fleet->fleet_id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Driver</label>
                            <select id="driverFilter" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">All Drivers</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Status</label>
                            <select id="statusFilter" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">All Status</option>
                                <option value="assigned">Assigned</option>
                                <option value="en_route">En Route</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 space-x-3">
                        <button id="resetFilters" class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                            Reset
                        </button>
                        <button id="applyFilters" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Apply Filters
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold">Task Assignments</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-4 px-6">Task ID</th>
                                    <th class="text-left py-4 px-6">Fleet</th>
                                    <th class="text-left py-4 px-6">Driver</th>
                                    <th class="text-left py-4 px-6">Route</th>
                                    <th class="text-left py-4 px-6">Status</th>
                                    <th class="text-left py-4 px-6">Assigned At</th>
                                    <th class="text-left py-4 px-6">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($tasks as $task)
                                @php
                                    $statusColor = match($task->status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'en_route' => 'bg-blue-100 text-blue-700',
                                        'assigned' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp

                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-blue-600 font-medium">{{ $task->task_number }}</td>
                                    <td class="px-6 py-4">{{ $task->fleet?->fleet_id ?? '—' }}</td>
                                    <td class="px-6 py-4">{{ $task->driver?->name ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        {{ $task->origin ?? '—' }} →
                                        {{ $task->destination ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $task->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('manager.fleet-device') }}#fleet-{{ $task->fleet_id ?? '' }}" 
                                           class="text-blue-600 hover:text-blue-700 text-sm">
                                            View Fleet
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        No task assignments found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
                    </p>
                    <div class="flex space-x-2">
                        {{ $tasks->links() }} <!-- ✅ Pagination real -->
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Apply Filters
    document.getElementById('applyFilters')?.addEventListener('click', function() {
        const fleetId = document.getElementById('fleetFilter').value;
        const driverId = document.getElementById('driverFilter').value;
        const status = document.getElementById('statusFilter').value;
        
        let url = new URL(window.location);
        url.searchParams.delete('fleet');
        url.searchParams.delete('driver');
        url.searchParams.delete('status');
        
        if (fleetId) url.searchParams.set('fleet', fleetId);
        if (driverId) url.searchParams.set('driver', driverId);
        if (status) url.searchParams.set('status', status);
        
        window.location.href = url.toString();
    });

    // Reset Filters
    document.getElementById('resetFilters')?.addEventListener('click', function() {
        window.location.href = '{{ route("report.route-history") }}';
    });
});
</script>
@endsection