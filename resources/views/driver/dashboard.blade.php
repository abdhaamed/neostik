<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - Fleet Management</title>
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
                        <a href="{{ route('driver.dashboard') }}" class="text-blue-600 font-semibold px-3 py-2 border-b-2 border-blue-600">
                            <i class="fas fa-home mr-1"></i>Dashboard
                        </a>
                        <a href="{{ route('driver.available.tasks') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2">
                            <i class="fas fa-list mr-1"></i>Available Tasks
                        </a>
                        <a href="{{ route('driver.shipments') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2">
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <i class="fas fa-shipping-fast text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Shipments</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $activeShipments }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed Today</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $completedToday }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Pickups</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $pendingPickups }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Active Tasks -->
        @if($myActiveTasks && $myActiveTasks->count() > 0)
        <div class="bg-white rounded-lg shadow-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600">
                <h2 class="text-lg font-semibold text-white">
                    <i class="fas fa-tasks mr-2"></i>My Active Tasks
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($myActiveTasks as $task)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $task->task_number }}</h3>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>{{ $task->delivery_date->format('d M Y') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($task->status == 'assigned') bg-yellow-100 text-yellow-800
                                @elseif($task->status == 'approved') bg-blue-100 text-blue-800
                                @endif">
                                {{ strtoupper($task->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-1 text-green-500"></i><strong>From:</strong> {{ $task->origin }}</p>
                                <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-1 text-red-500"></i><strong>To:</strong> {{ $task->destination }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600"><i class="fas fa-box mr-1"></i><strong>Goods:</strong> {{ $task->goods_type }}</p>
                                <p class="text-sm text-gray-600"><i class="fas fa-truck mr-1"></i><strong>Vehicle:</strong> {{ $task->fleet->license_plate ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('driver.task.detail', $task->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center transition-colors">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                            @if($task->status == 'assigned')
                            <form action="{{ route('driver.task.start', $task->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-play mr-1"></i>Start Task
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Available Tasks -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-500 to-green-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-white">
                        <i class="fas fa-clipboard-list mr-2"></i>Available Tasks
                    </h2>
                    <a href="{{ route('driver.available.tasks') }}" class="text-white hover:text-gray-200 text-sm">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($availableTasks && $availableTasks->count() > 0)
                <div class="space-y-4">
                    @foreach($availableTasks as $task)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow bg-gray-50">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $task->task_number }}</h3>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>Delivery: {{ $task->delivery_date->format('d M Y') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                <i class="fas fa-circle text-green-500 mr-1"></i>AVAILABLE
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-1 text-green-500"></i><strong>From:</strong> {{ $task->origin }}</p>
                                <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-1 text-red-500"></i><strong>To:</strong> {{ $task->destination }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600"><i class="fas fa-box mr-1"></i><strong>Goods:</strong> {{ $task->goods_type }}</p>
                                <p class="text-sm text-gray-600"><i class="fas fa-truck mr-1"></i><strong>Vehicle:</strong> {{ $task->fleet->license_plate ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <form action="{{ route('driver.task.claim', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg transition-all font-semibold">
                                <i class="fas fa-hand-paper mr-2"></i>Claim This Task
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">No available tasks at the moment</p>
                    <p class="text-gray-400 text-sm">Check back later for new delivery tasks</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>