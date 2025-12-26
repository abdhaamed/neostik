@extends('driver.layouts.app')

@section('title', 'My Shipments')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">My Shipments</h1>
    <p class="text-gray-600">View and manage all your assigned shipments</p>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-lg mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8 px-6" aria-label="Tabs">
            <button class="filter-tab active border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600" data-status="all">
                All Shipments
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-status="assigned">
                Assigned
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-status="en_route">
                En Route
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-status="completed">
                Completed
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-status="cancelled">
                Cancelled
            </button>
        </nav>
    </div>
</div>

<!-- Shipments List -->
<div class="bg-white rounded-lg shadow-lg p-6">
    @if($tasks->count() > 0)
        <div class="space-y-4" id="tasksContainer">
            @foreach($tasks as $task)
            <!-- Shipment Card -->
            <div class="task-card border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow" data-status="{{ $task->status }}">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Task #{{ $task->task_number }}</h3>
                        <p class="text-sm text-gray-500">
                            Assigned on {{ $task->created_at->format('M d, Y') }}
                            @if($task->fleet)
                                • Fleet: {{ $task->fleet->fleet_id }}
                            @endif
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if($task->status === 'assigned') bg-orange-100 text-orange-800
                        @elseif($task->status === 'en_route') bg-blue-100 text-blue-800
                        @elseif($task->status === 'completed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Origin</p>
                        <p class="font-medium text-gray-800">{{ $task->origin ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Destination</p>
                        <p class="font-medium text-gray-800">{{ $task->destination ?? '—' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-sm">
                    @if($task->cargo_type)
                    <div>
                        <p class="text-gray-500">Cargo Type</p>
                        <p>{{ $task->cargo_type }}</p>
                    </div>
                    @endif
                    @if($task->cargo_volume)
                    <div>
                        <p class="text-gray-500">Volume</p>
                        <p>{{ $task->cargo_volume }}</p>
                    </div>
                    @endif
                    @if($task->operating_cost)
                    <div>
                        <p class="text-gray-500">Operating Cost</p>
                        <p>Rp {{ number_format($task->operating_cost, 0, ',', '.') }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        @if($task->fleet?->device)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span>
                                @if($task->fleet->device->latitude && $task->fleet->device->longitude)
                                    {{ number_format($task->fleet->device->latitude, 6) }}, {{ number_format($task->fleet->device->longitude, 6) }}
                                @else
                                    No location
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        View Details
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No shipments assigned</h3>
            <p class="text-gray-500 mb-6">You don't have any shipments assigned yet</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Filter tabs functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            document.querySelectorAll('.filter-tab').forEach(t => {
                t.classList.remove('border-blue-500', 'text-blue-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-500', 'text-blue-600');

            // Filter tasks
            const status = this.dataset.status;
            document.querySelectorAll('.task-card').forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
});
</script>
@endpush