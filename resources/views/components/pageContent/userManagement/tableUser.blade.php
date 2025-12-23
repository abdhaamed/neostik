<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">ID Driver</th>
                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Name</th>
                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Status</th>
                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Availability</th>
                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Rating</th>
                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Number of Completed Deliveries</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drivers as $driver)
            <tr class="border-b border-gray-100 hover:bg-gray-50 cursor-pointer" 
                onclick="showDriverDetail({{ $driver->id }})">
                
                <!-- Driver Code -->
                <td class="py-4 px-4 text-sm text-gray-700 font-medium">
                    {{ $driver->driver_code }}
                </td>

                <!-- Name -->
                <td class="py-4 px-4 text-sm text-gray-700">
                    {{ $driver->user->name }}
                </td>

                <!-- Current Status -->
                <td class="py-4 px-4">
                    @php
                    $statusConfig = [
                        'no_task' => ['label' => 'No Task', 'color' => 'bg-gray-400'],
                        'assigned' => ['label' => 'Assigned', 'color' => 'bg-orange-500'],
                        'en_route' => ['label' => 'En Route', 'color' => 'bg-green-500']
                    ];
                    $status = $statusConfig[$driver->current_status] ?? ['label' => 'Unknown', 'color' => 'bg-gray-400'];
                    @endphp
                    
                    <span class="flex items-center gap-2 text-sm">
                        <span class="w-2 h-2 {{ $status['color'] }} rounded-full"></span>
                        <span class="text-gray-700">{{ $status['label'] }}</span>
                    </span>
                </td>

                <!-- Availability -->
                <td class="py-4 px-4 text-sm">
                    @if($driver->availability == 'available')
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">
                        Available
                    </span>
                    @else
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-medium">
                        On Leave
                    </span>
                    @endif
                </td>

                <!-- Rating -->
                <td class="py-4 px-4 text-sm text-gray-700">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>{{ number_format($driver->rating, 1) }}/5</span>
                    </div>
                </td>

                <!-- Total Completed -->
                <td class="py-4 px-4 text-sm text-gray-700">
                    {{ $driver->total_completed }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-12 text-center text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-lg font-medium">No Drivers Available</p>
                    <p class="text-sm mt-2">Add a new driver to get started</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    // Show Driver Detail Modal/Panel
    function showDriverDetail(driverId) {
        // TODO: Implement detail modal atau redirect ke detail page
        console.log('Show detail for driver:', driverId);
        
        // Example: Load detail via AJAX
        /*
        fetch(`/manager/user-management/driver/${driverId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show modal dengan data driver
                console.log(data.data);
            }
        })
        .catch(error => console.error('Error:', error));
        */
    }
</script>