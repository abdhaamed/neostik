@extends('driver.layouts.app')
@section('title', 'Task Detail - ' . $task->task_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('driver.shipments') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to My Shipments
    </a>
    <h1 class="text-3xl font-bold text-gray-800">Task #{{ $task->task_number }}</h1>
    <p class="text-gray-600">Detailed information of your assigned task</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Task Information -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Task Information</h2>
        <div class="space-y-3 text-sm">
            <div><span class="font-medium text-gray-700">Origin:</span> {{ $task->origin }}</div>
            <div><span class="font-medium text-gray-700">Destination:</span> {{ $task->destination }}</div>
            <div><span class="font-medium text-gray-700">Cargo Type:</span> {{ $task->cargo_type ?? '—' }}</div>
            <div><span class="font-medium text-gray-700">Volume:</span> {{ $task->cargo_volume ?? '—' }}</div>
            <div><span class="font-medium text-gray-700">Vehicle Plate:</span> {{ $task->vehicle_plate ?? '—' }}</div>
            <div><span class="font-medium text-gray-700">Operating Cost:</span> Rp {{ number_format($task->operating_cost ?? 0, 0, ',', '.') }}</div>
            <div>
                <span class="font-medium text-gray-700">Status:</span>
                <span class="ml-2 px-2 py-1 rounded text-xs font-medium
                    @if($task->status === 'assigned') bg-orange-100 text-orange-800
                    @elseif($task->status === 'en_route') bg-blue-100 text-blue-800
                    @elseif($task->status === 'completed') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
            </div>
            <div><span class="font-medium text-gray-700">Assigned At:</span> {{ $task->created_at->format('d M Y H:i') }}</div>
        </div>
    </div>

    <!-- Fleet & Location -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Fleet & Location</h2>
        @if($task->fleet)
        <div class="space-y-3 text-sm">
            <div><span class="font-medium text-gray-700">Fleet ID:</span> {{ $task->fleet->fleet_id }}</div>
            <div><span class="font-medium text-gray-700">Fleet Status:</span> {{ $task->fleet->status }}</div>
            @if($task->fleet->device)
            <div><span class="font-medium text-gray-700">Device ID:</span> {{ $task->fleet->device->device_id }}</div>
            <div><span class="font-medium text-gray-700">Location:</span>
                @if($task->fleet->device->latitude && $task->fleet->device->longitude)
                {{ number_format($task->fleet->device->latitude, 6) }}, {{ number_format($task->fleet->device->longitude, 6) }}
                @else
                Not available
                @endif
            </div>
            <div><span class="font-medium text-gray-700">Speed:</span> {{ $task->fleet->device->speed ?? '—' }} km/h</div>
            <div><span class="font-medium text-gray-700">Address:</span> {{ $task->fleet->device->address ?? '—' }}</div>
            @else
            <p class="text-gray-500">No device associated with this fleet.</p>
            @endif
        </div>
        @else
        <p class="text-gray-500">Fleet information not available.</p>
        @endif
    </div>
</div>

<!-- Action Buttons -->
<div class="mt-8 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Task Actions</h2>

    @if($task->status === 'assigned')
    <!-- ✅ Tambahkan action attribute sebagai fallback -->
    <form id="startJourneyForm" 
          action="{{ route('driver.tasks.enroute', $task) }}" 
          method="POST" 
          class="space-y-4" 
          enctype="multipart/form-data">
        @csrf
        <!-- ❌ Hapus input hidden fleet_id (tidak diperlukan di DriverTaskController) -->
        <input type="hidden" name="recipient" value="{{ auth()->user()->name }}">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (Start Journey)</label>
            <textarea name="description" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. Berangkat dari gudang menuju Surabaya"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Report / Photo (Optional)</label>
            <input type="file" name="report" accept="image/*"
                class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Start Journey → En Route
        </button>
    </form>

    @elseif($task->status === 'en_route')
    <!-- ✅ Tambahkan action attribute sebagai fallback -->
    <form id="completeTaskForm" 
          action="{{ route('driver.tasks.complete', $task) }}" 
          method="POST" 
          class="space-y-4" 
          enctype="multipart/form-data">
        @csrf
        <!-- ❌ Hapus input hidden fleet_id -->
        <input type="hidden" name="recipient" value="{{ auth()->user()->name }}">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (Complete Task)</label>
            <textarea name="description" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. Barang telah diterima oleh pihak PT Sejahtera"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Report / Proof of Delivery (Optional)</label>
            <input type="file" name="report" accept="image/*"
                class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
            Complete Task
        </button>
    </form>
    @else
    <p class="text-gray-600">No actions available for this task status.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('startJourneyForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'Processing...';

    try {
        // ✅ Gunakan URL dari action attribute (lebih aman)
        const url = this.getAttribute('action');
        const res = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();
        if (data.success) {
            showToast('Journey started successfully!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Failed to start journey', 'error');
        }
    } catch (err) {
        console.error(err);
        showToast('Network error', 'error');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Start Journey → En Route';
    }
});

document.getElementById('completeTaskForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'Processing...';

    try {
        // ✅ Gunakan URL dari action attribute
        const url = this.getAttribute('action');
        const res = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();
        if (data.success) {
            showToast('Task completed successfully!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Failed to complete task', 'error');
        }
    } catch (err) {
        console.error(err);
        showToast('Network error', 'error');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Complete Task';
    }
});
</script>
@endpush