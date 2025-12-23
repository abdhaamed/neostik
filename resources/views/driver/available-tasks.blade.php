<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Tasks - Fleet Management</title>
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
                        <a href="{{ route('driver.available.tasks') }}" class="text-blue-600 font-semibold px-3 py-2 border-b-2 border-blue-600">
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

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-clipboard-list mr-2"></i>Available Tasks
            </h2>
            <p class="text-gray-600 mt-2">Browse and claim available delivery tasks</p>
        </div>

        <!-- Tasks Grid -->
        @if($tasks && $tasks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @foreach($tasks as $task)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $task->task_number }}</h3>
                            <p class="text-green-100 text-sm">
                                <i class="fas fa-calendar mr-1"></i>{{ $task->delivery_date->format('d M Y') }}
                            </p>
                        </div>
                        <span class="bg-white text-green-600 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-circle text-green-500 mr-1"></i>AVAILABLE
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Route Info -->
                    <div class="mb-4">
                        <div class="flex items-start mb-2">
                            <i class="fas fa-map-marker-alt text-green-500 mt-1 mr-2"></i>
                            <div>
                                <p class="text-xs text-gray-500">Origin</p>
                                <p class="font-semibold text-gray-800">{{ $task->origin }}</p>
                            </div>
                        </div>
                        <div class="flex items-center my-2 ml-2">
                            <i class="fas fa-arrow-down text-gray-400"></i>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-2"></i>
                            <div>
                                <p class="text-xs text-gray-500">Destination</p>
                                <p class="font-semibold text-gray-800">{{ $task->destination }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Task Details -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Goods Type</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-box mr-1 text-blue-500"></i>{{ $task->goods_type }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Vehicle</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-truck mr-1 text-blue-500"></i>{{ $task->fleet->license_plate ?? 'N/A' }}
                            </p>
                        </div>
                        @if($task->fleet && $task->fleet->category)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Category</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-tag mr-1 text-purple-500"></i>{{ $task->fleet->category->name }}
                            </p>
                        </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Created By</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-user mr-1 text-orange-500"></i>{{ $task->creator->name ?? 'System' }}
                            </p>
                        </div>
                    </div>

                    <!-- Claim Button -->
                    <form action="{{ route('driver.task.claim', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to claim this task?');">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-3 rounded-lg transition-all font-semibold text-lg">
                            <i class="fas fa-hand-paper mr-2"></i>Claim This Task
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
        @else
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Available Tasks</h3>
            <p class="text-gray-500">There are currently no tasks available to claim.</p>
            <p class="text-gray-400 text-sm mt-2">Check back later for new delivery tasks</p>
            <a href="{{ route('driver.dashboard') }}" class="inline-block mt-6 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-home mr-2"></i>Back to Dashboard
            </a>
        </div>
        @endif
    </div>
</body>
</html>