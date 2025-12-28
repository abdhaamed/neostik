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

    <div class="flex-1 flex flex-col" style="margin-left: 60px;">
        <header class="px-4 py-2">
            @include('components.headerTop.headerTab')
            @include('components.headerTop.badgeStatus')
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Page Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Operational Report</h1>
                        <p class="text-gray-600 mt-1">Real-time fleet and task performance metrics</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                    $statsData = [
                    ['title' => 'Total Tasks', 'value' => number_format($stats['total_tasks']), 'color' => 'blue'],
                    ['title' => 'Active Fleets', 'value' => number_format($stats['active_fleets']), 'color' => 'green'],
                    ['title' => 'Completed Tasks', 'value' => number_format($stats['completed_tasks']), 'color' => 'purple'],
                    ['title' => 'Pending Assignments', 'value' => number_format($stats['pending_assignments']), 'color' => 'yellow'],
                    ];
                    @endphp

                    @foreach($statsData as $stat)
                    <div
                        class="bg-white rounded-lg shadow p-6 border-l-4 border-{{ $stat['color'] }}-500 hover:scale-105 transition">
                        <p class="text-gray-500 text-sm">{{ $stat['title'] }}</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stat['value'] }}</h3>
                    </div>
                    @endforeach
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Task Status Distribution</h3>
                        <div class="relative h-80">
                            <canvas id="taskStatusChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Fleet Status Distribution</h3>
                        <div class="relative h-80">
                            <canvas id="fleetStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Tasks Table -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Tasks</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3">Task #</th>
                                    <th>Driver</th>
                                    <th>Fleet</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTasks as $task)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3">{{ $task->task_number }}</td>
                                    <td>{{ $task->driver->name ?? '—' }}</td>
                                    <td>{{ $task->fleet->fleet_id ?? '—' }}</td>
                                    <td>
                                        <span class="px-2 py-1 text-xs rounded-full
                                                @if($task->status === 'completed') bg-green-100 text-green-800
                                                @elseif($task->status === 'en_route') bg-blue-100 text-blue-800
                                                @elseif($task->status === 'assigned') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $task->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    /* ===============================
       RAW DATA FROM BACKEND (SAFE)
    =============================== */
    const taskStatusCounts = @json($taskStatusCounts);
    const fleetStatusCounts = @json($fleetStatusCounts);

    /* ===============================
       TASK STATUS CHART
    =============================== */
    new Chart(document.getElementById('taskStatusChart'), {
        type: 'bar',
        data: {
            labels: ['Completed', 'En Route', 'Assigned'],
            datasets: [{
                label: 'Tasks',
                data: [
                    taskStatusCounts.completed ?? 0,
                    taskStatusCounts.en_route ?? 0,
                    taskStatusCounts.assigned ?? 0
                ],
                backgroundColor: [
                    'rgb(34,197,94)',
                    'rgb(59,130,246)',
                    'rgb(251,146,60)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    /* ===============================
       FLEET STATUS CHART
    =============================== */
    new Chart(document.getElementById('fleetStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Unassigned', 'Assigned', 'En Route', 'Completed'],
            datasets: [{
                data: [
                    fleetStatusCounts.Unassigned ?? 0,
                    fleetStatusCounts.Assigned ?? 0,
                    fleetStatusCounts['En Route'] ?? 0,
                    fleetStatusCounts.Completed ?? 0
                ],
                backgroundColor: [
                    'rgb(156,163,175)',
                    'rgb(251,146,60)',
                    'rgb(59,130,246)',
                    'rgb(34,197,94)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    /* ===============================
       DEFAULT DATE
    =============================== */
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        const lastWeek = new Date(today - 7 * 24 * 60 * 60 * 1000);
        document.getElementById('startDate').valueAsDate = lastWeek;
        document.getElementById('endDate').valueAsDate = today;
    });
</script>
@endsection
