@php
$fleet = $fleet ?? null;
$device = $device ?? null;
$latestGps = $device?->gpsLogs()->latest()->first();
$activityLogs = $device?->activityLogs()->latest()->limit(10)->get() ?? collect();
@endphp

<!-- Device Information -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Device Information</h3>
    @if($device)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <p><span class="font-semibold">Device Code:</span> {{ $device->device_code }}</p>
            <p><span class="font-semibold">IMEI Number:</span> {{ $device->imei_number }}</p>
            <p><span class="font-semibold">SIM Card Number:</span> {{ $device->sim_card_number ?? '—' }}</p>
        </div>
        <div class="space-y-4">
            <p><span class="font-semibold">Connection Status:</span> 
                <span class="{{ $device->connection_status == 'connected' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($device->connection_status) }}
                </span>
            </p>
            <p><span class="font-semibold">Last Update:</span> 
                {{ $device->last_update ? $device->last_update->format('d M Y, H:i') . ' WIB' : '—' }}
            </p>
            <p><span class="font-semibold">Signal Strength:</span> {{ $device->signal_strength ?? 'Unknown' }}</p>
        </div>
    </div>
    @else
    <div class="text-center py-12 text-gray-400">
        <p>No Device Assigned</p>
    </div>
    @endif
</div>

@if($device)
<!-- Current Location -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Current Location</h3>
    @if($latestGps)
    <p><span class="font-semibold">Latitude:</span> {{ $latestGps->latitude }}</p>
    <p><span class="font-semibold">Longitude:</span> {{ $latestGps->longitude }}</p>
    <p><span class="font-semibold">Speed:</span> {{ $latestGps->speed ?? 0 }} km/h</p>
    <p><span class="font-semibold">Address:</span> {{ $latestGps->address ?? 'Address not available' }}</p>
    <p><span class="font-semibold">Last Update:</span> {{ $latestGps->timestamp->format('d M Y, H:i:s') }} WIB</p>
    @else
    <p class="text-gray-400">No GPS data available</p>
    @endif
</div>

<!-- Activity History -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Device Activity History</h3>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b-2 border-gray-200">
                <th class="text-left py-3 px-4">Timestamp</th>
                <th class="text-left py-3 px-4">Event</th>
                <th class="text-left py-3 px-4">Location</th>
                <th class="text-left py-3 px-4">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activityLogs as $log)
            <tr class="border-b border-gray-100">
                <td class="py-3 px-4">{{ $log->timestamp->format('d M Y, H:i') }}</td>
                <td class="py-3 px-4">{{ $log->event }}</td>
                <td class="py-3 px-4">
                    {{ $log->location ?? ($log->latitude && $log->longitude ? "Lat: {$log->latitude}, Lng: {$log->longitude}" : '—') }}
                </td>
                <td class="py-3 px-4">
                    @php
                    $statusColors = [
                        'active' => 'bg-green-100 text-green-700',
                        'started' => 'bg-blue-100 text-blue-700',
                        'idle' => 'bg-yellow-100 text-yellow-700',
                        'stopped' => 'bg-gray-100 text-gray-700',
                        'connected' => 'bg-green-100 text-green-700',
                        'disconnected' => 'bg-red-100 text-red-700'
                    ];
                    $statusClass = $statusColors[strtolower($log->status ?? 'active')] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                        {{ ucfirst($log->status ?? 'Active') }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-8 text-center text-gray-400">No activity logs available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif
