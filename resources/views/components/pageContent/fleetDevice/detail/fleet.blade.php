@php
$fleet = $selectedFleet ?? null; // Pastikan yang dipakai adalah selectedFleet
$activeTask = $fleet?->tasks->first() ?? null;
$driver = $activeTask?->driver?->user ?? null;
$statusLogs = $fleet?->statusLogs ?? collect();
$currentStatus = $fleet->current_status ?? 'unassigned';
@endphp

<!-- Fleet Information -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Fleet Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-semibold text-gray-600">License Plate</p>
            <p class="text-gray-800">{{ $fleet?->license_plate ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Serial Number</p>
            <p class="text-gray-800">{{ $fleet?->serial_number ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Category</p>
            <p class="text-gray-800">{{ $fleet?->category?->name ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Capacity</p>
            <p class="text-gray-800">{{ $fleet?->capacity ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Current Status</p>
            <p class="text-gray-800">{{ ucfirst($currentStatus) }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Fleet Image</p>
            @if($fleet?->image)
                <img src="{{ asset('storage/' . $fleet->image) }}" class="mt-2 w-48 h-24 object-cover rounded">
            @else
                <p class="text-gray-400">No image</p>
            @endif
        </div>
    </div>
</div>

<!-- Device Information -->
@if($fleet?->device)
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Device Information</h3>
    <p><span class="font-semibold">Device Code:</span> {{ $fleet->device->device_code ?? '-' }}</p>
    <p><span class="font-semibold">IMEI Number:</span> {{ $fleet->device->imei_number ?? '-' }}</p>
    <p><span class="font-semibold">SIM Card Number:</span> {{ $fleet->device->sim_card_number ?? '-' }}</p>
    <p><span class="font-semibold">Connection Status:</span> {{ ucfirst($fleet->device->connection_status ?? 'disconnected') }}</p>
</div>
@endif

<!-- Active Task -->
@if($activeTask)
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Active Task</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="font-semibold text-gray-600">Task Number</p>
            <p class="text-gray-800">{{ $activeTask->task_number }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Delivery Date</p>
            <p class="text-gray-800">{{ $activeTask->delivery_date?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Status</p>
            <p class="text-gray-800">{{ ucfirst($activeTask->status ?? '-') }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Origin</p>
            <p class="text-gray-800">{{ $activeTask->origin ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Destination</p>
            <p class="text-gray-800">{{ $activeTask->destination ?? '-' }}</p>
        </div>
    </div>

    @if($driver)
    <div class="mt-4 flex items-center space-x-3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden bg-gray-300">
            @if($driver->profile_photo_path)
                <img src="{{ asset('storage/' . $driver->profile_photo_path) }}" alt="{{ $driver->name }}" class="w-full h-full object-cover">
            @else
                <span class="text-lg font-bold text-gray-600">{{ substr($driver->name, 0, 1) }}</span>
            @endif
        </div>
        <div>
            <p class="font-medium text-gray-800">{{ $driver->name }}</p>
            <p class="text-xs text-gray-600">{{ $driver->email }}</p>
        </div>
    </div>
    @endif
</div>
@else
<div class="bg-white rounded-lg shadow p-6 mb-6 text-center text-gray-400">
    <p>No Active Task</p>
</div>
@endif

<!-- Status Logs / Bukti Operasional -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Bukti Operasional</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Recipient</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Description</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Report</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statusLogs as $log)
                @php
                    $statusClasses = [
                        'unassigned' => 'bg-gray-100 text-gray-700',
                        'assigned' => 'bg-orange-100 text-orange-700',
                        'en_route' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-green-100 text-green-700'
                    ];
                    $rowClass = $statusClasses[$log->status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <tr class="border-b border-gray-100 hover:bg-gray-50 {{ $rowClass }}">
                    <td class="py-3 px-4">{{ ucfirst(str_replace('_', ' ', $log->status)) }}</td>
                    <td class="py-3 px-4">{{ $log->recipient ?? '—' }}</td>
                    <td class="py-3 px-4">{{ $log->description ?? 'No description' }}</td>
                    <td class="py-3 px-4">
                        @if($log->report_image)
                        <a href="{{ asset('storage/' . $log->report_image) }}" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-xs font-medium">Show</a>
                        @else
                        <span class="text-xs text-gray-400">No report</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-gray-400">No operational evidence recorded</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
