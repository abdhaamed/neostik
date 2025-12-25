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
            <button class="filter-tab border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                All Shipments
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Active
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Completed
            </button>
            <button class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Cancelled
            </button>
        </nav>
    </div>
</div>

<!-- Shipments List -->
<div class="bg-white rounded-lg shadow-lg p-6">
    @if(count($shipments) > 0)
        <div class="space-y-4">
            @foreach($shipments as $shipment)
            <!-- Shipment Card (Template for future use) -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Shipment #{{ $shipment->id }}</h3>
                        <p class="text-sm text-gray-500">{{ $shipment->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Active
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Pickup Location</p>
                        <p class="font-medium text-gray-800">{{ $shipment->pickup_location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Delivery Location</p>
                        <p class="font-medium text-gray-800">{{ $shipment->delivery_location }}</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $shipment->distance }} km</span>
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
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No shipments found</h3>
            <p class="text-gray-500 mb-6">You don't have any shipments assigned yet</p>
            <a href="{{ route('driver.dashboard') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Back to Dashboard
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
// Filter tabs functionality
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active state from all tabs
        document.querySelectorAll('.filter-tab').forEach(t => {
            t.classList.remove('border-blue-500', 'text-blue-600');
            t.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Add active state to clicked tab
        this.classList.remove('border-transparent', 'text-gray-500');
        this.classList.add('border-blue-500', 'text-blue-600');
        
        // TODO: Filter shipments based on selected tab
    });
});
</script>
@endpush
@endsection