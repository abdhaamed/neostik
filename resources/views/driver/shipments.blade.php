<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shipments - Fleet Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-bold text-gray-800">Fleet Management</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('driver.dashboard') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2">Dashboard</a>
                        <a href="{{ route('driver.shipments') }}" class="text-blue-600 font-semibold px-3 py-2">My Shipments</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Driver</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">My Shipments</h2>
            <p class="text-gray-600">View and manage all your assigned shipments</p>
        </div>

        <!-- Shipments Table (kosong) -->
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            No shipments found
        </div>
    </div>
</body>
</html>
