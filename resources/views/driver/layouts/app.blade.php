<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Driver Dashboard') - NeoStik Fleet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-bold text-blue-600">NeoStik Fleet</h1>
                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('driver.dashboard') }}"
                            class="px-4 py-2 rounded-lg font-medium transition-colors {{ request()->routeIs('driver.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('driver.shipments') }}"
                            class="px-4 py-2 rounded-lg font-medium transition-colors {{ request()->routeIs('driver.shipments') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                            My Shipments
                        </a>
                        <a href="{{ route('driver.profile') }}"
                            class="px-4 py-2 rounded-lg font-medium transition-colors {{ request()->routeIs('driver.profile') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                            Profile
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    <!-- User Info -->
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->driver_id }}</p>
                    </div>
                    <!-- Avatar -->
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ Auth::user()->initials }}
                    </div>
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                            Logout
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 transform translate-x-full transition-transform duration-300 z-50 hidden">
        <div class="flex items-center space-x-3">
            <div id="toastIcon"></div>
            <p id="toastMessage" class="text-gray-800 font-medium"></p>
        </div>
    </div>

    <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');

            if (type === 'success') {
                toastIcon.innerHTML = '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            } else if (type === 'error') {
                toastIcon.innerHTML = '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            }

            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }, 3000);
        }
    </script>

    @stack('scripts')
</body>
</html>