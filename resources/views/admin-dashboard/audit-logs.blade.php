@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Left Bar - Always visible (Logo + Hamburger) -->
    @include('components.sidebar.humbergerButton')
    
    <!-- Sidebar - Default hidden -->
    <aside id="sidebar" class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
        @include('components.sidebar.sidebar')
        @include('components.sidebar.profile')
    </aside>
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col" style="margin-left: 60px;">
        <header class="px-4 py-2">
            @include('components.headerTop.headerTab')
            @include('components.headerTop.badgeStatus')
        </header>
        
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto space-y-6">
                
                <!-- Page Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Audit Logs</h1>
                        <p class="text-gray-600 mt-1">Monitor system activities and user actions</p>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-3">
                        <button class="px-6 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Export Logs
                        </button>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6 transform transition-all duration-200 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Today's Actions</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-2">247</h3>
                            </div>
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 transform transition-all duration-200 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Critical Events</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-2">3</h3>
                            </div>
                            <div class="bg-red-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 transform transition-all duration-200 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Active Users</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-2">18</h3>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 transform transition-all duration-200 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Failed Actions</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-2">7</h3>
                            </div>
                            <div class="bg-yellow-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" placeholder="Search logs..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Action Type</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Actions</option>
                                <option>Login</option>
                                <option>Logout</option>
                                <option>Create</option>
                                <option>Update</option>
                                <option>Delete</option>
                                <option>Assign Task</option>
                                <option>Accept Task</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">User Role</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Roles</option>
                                <option>Admin</option>
                                <option>Driver</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Severity</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Levels</option>
                                <option>Info</option>
                                <option>Warning</option>
                                <option>Error</option>
                                <option>Critical</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Activities</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            @php
                            $activities = [
                                [
                                    'time' => '2 minutes ago',
                                    'user' => 'Admin (You)',
                                    'action' => 'Viewed audit logs',
                                    'type' => 'View',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>',
                                    'details' => 'Page: /audit-logs'
                                ],
                                [
                                    'time' => '5 minutes ago',
                                    'user' => 'John Doe (Driver)',
                                    'action' => 'Submitted completion evidence',
                                    'type' => 'Submit',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                    'details' => 'Task: TSK-2024-045, Fleet: FLEET-003'
                                ],
                                [
                                    'time' => '12 minutes ago',
                                    'user' => 'Admin',
                                    'action' => 'Accepted completed task',
                                    'type' => 'Accept',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                    'details' => 'Fleet: FLEET-001, Driver: Jane Smith'
                                ],
                                [
                                    'time' => '18 minutes ago',
                                    'user' => 'Admin',
                                    'action' => 'Created new driver account',
                                    'type' => 'Create',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>',
                                    'details' => 'Driver: Mike Johnson, Email: mike@example.com'
                                ],
                                [
                                    'time' => '25 minutes ago',
                                    'user' => 'Admin',
                                    'action' => 'Assigned task to driver',
                                    'type' => 'Assign',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
                                    'details' => 'Task: TSK-2024-044, Driver: Tom Brown, Fleet: FLEET-005'
                                ],
                                [
                                    'time' => '32 minutes ago',
                                    'user' => 'System',
                                    'action' => 'Failed login attempt',
                                    'type' => 'Security',
                                    'severity' => 'warning',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                                    'details' => 'IP: 192.168.1.100, Email: unknown@email.com'
                                ],
                                [
                                    'time' => '45 minutes ago',
                                    'user' => 'Jane Smith (Driver)',
                                    'action' => 'Updated vehicle information',
                                    'type' => 'Update',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
                                    'details' => 'Vehicle: B 1234 XYZ, Type: Truck'
                                ],
                                [
                                    'time' => '1 hour ago',
                                    'user' => 'Admin',
                                    'action' => 'Added new fleet',
                                    'type' => 'Create',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>',
                                    'details' => 'Fleet: FLEET-010, Device: GPS-010'
                                ],
                                [
                                    'time' => '1 hour ago',
                                    'user' => 'Sarah Wilson (Driver)',
                                    'action' => 'Logged in',
                                    'type' => 'Login',
                                    'severity' => 'info',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>',
                                    'details' => 'IP: 192.168.1.50, Device: Mobile'
                                ],
                                [
                                    'time' => '2 hours ago',
                                    'user' => 'Admin',
                                    'action' => 'Deleted inactive driver',
                                    'type' => 'Delete',
                                    'severity' => 'warning',
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>',
                                    'details' => 'Driver ID: DRV-001, Reason: Inactive for 6 months'
                                ],
                            ];
                            @endphp

                            @foreach($activities as $activity)
                            <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    @php
                                        $iconColor = match($activity['severity']) {
                                            'warning' => 'bg-yellow-100 text-yellow-600',
                                            'error' => 'bg-red-100 text-red-600',
                                            'critical' => 'bg-red-100 text-red-600',
                                            default => 'bg-blue-100 text-blue-600'
                                        };
                                    @endphp
                                    <div class="w-10 h-10 rounded-full {{ $iconColor }} flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $activity['icon'] !!}
                                        </svg>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                <span class="text-blue-600">{{ $activity['user'] }}</span>
                                                {{ $activity['action'] }}
                                            </p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $activity['details'] }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            @php
                                                $badgeColor = match($activity['type']) {
                                                    'Create' => 'bg-green-100 text-green-700',
                                                    'Update' => 'bg-blue-100 text-blue-700',
                                                    'Delete' => 'bg-red-100 text-red-700',
                                                    'Security' => 'bg-yellow-100 text-yellow-700',
                                                    default => 'bg-gray-100 text-gray-700'
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $badgeColor }}">
                                                {{ $activity['type'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $activity['time'] }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-600">Showing 1 to 10 of 247 entries</p>
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script>
    // Auto-refresh every 30 seconds
    setInterval(() => {
        // location.reload();
        console.log('Auto-refresh disabled for demo');
    }, 30000);
</script>

@endsection