<div class="grid grid-cols-2 gap-4">
    @forelse($fleets as $fleet)
    <!-- Card -->
    <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer fleet-card"
        data-fleet-id="{{ $fleet->id }}"
        onclick="loadFleetDetail({{ $fleet->id }})">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-gray-800 font-semibold">{{ $fleet->license_plate }}</h4>
            <div class="flex items-center space-x-1">
                <span class="w-2 h-2 
                        @if($fleet->current_status == 'unassigned') bg-gray-400
                        @elseif($fleet->current_status == 'assigned') bg-orange-500
                        @elseif($fleet->current_status == 'en_route') bg-blue-500
                        @elseif($fleet->current_status == 'completed') bg-green-500
                        @endif rounded-full"></span>
                <span class="text-xs text-gray-600">{{ ucfirst(str_replace('_', ' ', $fleet->current_status)) }}</span>
            </div> 
        </div>

        @php
        // Get active task untuk fleet ini
        $activeTask = $fleet->tasks->first();
        
        // Dummy time calculation (nanti bisa diganti dengan real data)
        $currentTime = now()->format('H:i:s');
        $timeLeft = $activeTask ? '28 min left' : '—';
        @endphp

        <!-- Content Grid: Time | Timeline | Empty -->
        <div class="grid grid-cols-3 gap-4 mb-4">
            <!-- Left: Time Info -->
            <div class="flex flex-col">
                <span class="text-lg font-bold text-gray-800">{{ $currentTime }}</span>
                <span class="text-xs text-gray-500 mt-1">{{ $timeLeft }}</span>
            </div>

            <!-- Middle: Status Timeline -->
            <div class="flex flex-col space-y-2 relative pl-6">
                <!-- Vertical Line -->
                <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gray-300"></div>

                <!-- Status Items -->
                <!-- Completed -->
                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full 
                            @if($fleet->current_status == 'completed') bg-green-500
                            @else bg-gray-300
                            @endif border-2 border-white"></div>
                    <span class="text-xs text-gray-700">Completed</span>
                </div>

                <!-- En Route -->
                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full 
                            @if(in_array($fleet->current_status, ['en_route', 'completed'])) bg-blue-500
                            @else bg-gray-300
                            @endif border-2 border-white"></div>
                    <span class="text-xs text-gray-700">En Route</span>
                </div>

                <!-- Assigned -->
                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full 
                            @if(in_array($fleet->current_status, ['assigned', 'en_route', 'completed'])) bg-orange-500
                            @else bg-gray-300
                            @endif border-2 border-white"></div>
                    <span class="text-xs text-gray-700">Assigned</span>
                </div>

                <!-- Unassigned -->
                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full bg-gray-400 border-2 border-white"></div>
                    <span class="text-xs text-gray-700">Unassigned</span>
                </div>
            </div>

            <!-- Right: Empty Space -->
            <div></div>
        </div>

        <!-- Truck Image/Icon -->
        <div class="bg-gray-100 rounded h-24 flex items-center justify-center">
            @if($fleet->image)
            <img src="{{ asset('storage/' . $fleet->image) }}"
                alt="{{ $fleet->license_plate }}"
                class="w-16 h-16 object-contain"
                onerror="this.onerror=null; this.parentElement.innerHTML='<svg class=\'w-16 h-16 text-gray-400\' fill=\'currentColor\' viewBox=\'0 0 24 24\'><path d=\'M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z\'/></svg>';">
            @else
            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
            </svg>
            @endif
        </div>

        <!-- Additional Info (Optional) -->
        <div class="mt-3 pt-3 border-t border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-600">
                <span>{{ $fleet->category?->name ?? 'No Category' }}</span>
                @if($activeTask && $activeTask->driver)
                <span class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    {{ $activeTask->driver->user->name }}
                </span>
                @else
                <span class="text-gray-400">No driver</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="col-span-2 py-12 text-center text-gray-400">
        <svg class="w-20 h-20 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
        </svg>
        <p class="text-lg font-medium">No Fleets Available</p>
        <p class="text-sm mt-2">Add a new fleet to get started</p>
    </div>
    @endforelse
</div>