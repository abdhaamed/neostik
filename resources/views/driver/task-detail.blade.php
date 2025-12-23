<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shipments - Fleet Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-truck mr-2 text-blue-600"></i>Fleet Management
                    </h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('driver.dashboard') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2">
                            <i class="fas fa-home mr-1"></i>Dashboard
                        </a>
                        <a href="{{ route('driver.available.tasks') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2">
                            <i class="fas fa-list mr-1"></i>Available Tasks
                        </a>
                        <a href="{{ route('driver.shipments') }}" class="text-blue-600 font-semibold px-3 py-2 border-b-2 border-blue-600">
                            <i class="fas fa-box mr-1"></i>My Shipments
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Driver</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-box mr-2"></i>My Shipments
            </h2>
            <p class="text-gray-600 mt-2">View and manage all your assigned shipments</p>
        </div>

        <!-- Shipments Table -->
        @if($tasks && $tasks->count() > 0)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goods</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $task->task_number }}</div>
                                <div class="text-xs text-gray-500">{{ $task->created_at->format('d M Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-calendar mr-1 text-blue-500"></i>
                                    {{ $task->delivery_date->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <div class="mb-1">
                                        <i class="fas fa-map-marker-alt text-green-500 mr-1"></i>
                                        <span class="font-semibold">From:</span> {{ Str::limit($task->origin, 30) }}
                                    </div>
                                    <div>
                                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                        <span class="font-semibold">To:</span> {{ Str::limit($task->destination, 30) }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-box mr-1 text-purple-500"></i>
                                    {{ $task->goods_type }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-truck mr-1 text-orange-500"></i>
                                    {{ $task->fleet->license_plate ?? 'N/A' }}
                                </div>
                                @if($task->fleet && $task->fleet->category)
                                <div class="text-xs text-gray-500">{{ $task->fleet->category->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($task->status == 'assigned')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>ASSIGNED
                                </span>
                                @elseif($task->status == 'approved')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-truck mr-1"></i>IN PROGRESS
                                </span>
                                @elseif($task->status == 'completed')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>COMPLETED
                                </span>
                                @elseif($task->status == 'rejected')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>REJECTED
                                </span>
                                @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ strtoupper($task->status) }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('driver.task.detail', $task->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                
                                @if($task->status == 'assigned')
                                <form action="{{ route('driver.task.start', $task->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Start this task?')">
                                        <i class="fas fa-play mr-1"></i>Start
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
        @else
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Shipments Found</h3>
            <p class="text-gray-500">You don't have any shipments yet.</p>
            <p class="text-gray-400 text-sm mt-2">Claim available tasks from the dashboard to get started</p>
            <a href="{{ route('driver.available.tasks') }}" class="inline-block mt-6 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-clipboard-list mr-2"></i>View Available Tasks
            </a>
        </div>
        @endif
    </div>
</body>
</html>