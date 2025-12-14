<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Left Bar - Always visible (Logo + Hamburger) -->
        <div id="leftBar" class="fixed left-0 top-0 h-screen bg-gray-100 border-r border-gray-300 z-50 flex flex-col items-center py-4 px-2 transition-transform duration-300" style="width: 60px;">
            <!-- Logo -->
            <div class="mb-4 w-10 h-10 flex items-center justify-center">
                <img src="{{ asset('images/NEOSTIK.png') }}" alt="Logo" class="w-full h-full object-contain">
            </div>

            <!-- Hamburger Button -->
            <button onclick="toggleSidebar()" class="p-2 rounded hover:bg-gray-200">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Overlay - Click outside to close (transparent) -->
        <div id="overlay" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden"></div>

        <!-- Sidebar - Default hidden -->
        <aside id="sidebar" class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
            @include('components.sidebar')
            @include('components.profile')
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col" style="margin-left: 60px;">
            <!-- Header Top -->
            <header class="px-4 py-2">
                <div class="flex items-center justify-between bg-[#FFCD99] px-4 pt-2 -mx-4 -mt-2">
                    <!-- Tabs -->
                    <div class="flex space-x-1">
                        <div class="bg-white px-4 w-34  py-1.5 rounded-t-lg border border-b-0 border-orange-300 flex items-center space-x-2 text-xs justify-between">
                            <span class="font-medium">Hi! Welcome</span
                                <button class="text-gray-400 hover:text-gray-600 p-1 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg></button>
                        </div>
                        <div class="bg-orange-100 w-34 px-3 py-1.5 rounded-t-lg border border-b-0 border-orange-300 flex items-center space-x-2 text-xs justify-between">
                            <span class="font-medium">B 3922 ZHB</span>
                            <button class="text-gray-400 hover:text-gray-600 p-1 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            </button>
                        </div>
                        <button class="px-2 py-1.5 text-gray-500 hover:text-gray-700 text-sm">+</button>
                    </div>

                    <!-- Action Buttons -->

                </div>

                <!-- Status Badges -->
                <div class="flex space-x-4 mt-3">
                    <div class="bg-white px-4 py-1 rounded-md">
                        <span class="text-sm"><span class="font-bold">12</span> Unassigned</span>
                    </div>
                    <div class="bg-white px-4 py-1 rounded-md">
                        <span class="text-sm"><span class="font-bold">12</span> Assigned</span>
                    </div>
                    <div class="bg-white px-4 py-1 rounded-md">
                        <span class="text-sm"><span class="font-bold">12</span> En Route</span>
                    </div>
                    <div class="bg-white px-4 py-1 rounded-md">
                        <span class="text-sm"><span class="font-bold">12</span> Completed</span>
                    </div>
                </div>
            </header>

            <!-- Content with Map and Right Sidebar -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Map Area -->
                <main class="flex-1 relative bg-gray-200">
                    <!-- Ruang untuk Maps -->
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z" />
                            </svg>
                            <p class="text-lg font-medium">MAP AREA</p>
                        </div>
                    </div>
                </main>

                <!-- Right Sidebar -->
                <aside class="w-64 bg-white border-l border-gray-200 overflow-y-auto">
                    <!-- Fleets Section -->
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-3">Fleets</h3>
                        <div class="flex flex-wrap gap-2">
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-gray-200">Small Box</button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-gray-200">Curtain Side</button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-gray-200">Box Trailer</button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-gray-200">Pickup</button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-gray-200">Middle Box</button>
                            <button class="px-3 py-1 bg-gray-100 rounded-full text-sm hover:bg-gray-200">Container Box</button>
                        </div>
                        <div class="mt-3">
                            <input type="text" placeholder="Search" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Vehicle List -->
                    <div class="divide-y divide-gray-200">
                        <!-- Vehicle Item 1 -->
                        <div class="p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <!-- Truck Icon Placeholder -->
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-gray-800">B 7832 POM</h4>
                                    </div>
                                    <p class="text-xs text-gray-500">Carrying Chemical</p>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Item 2 -->
                        <div class="p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-gray-800">B 8131 NSA</h4>
                                    </div>
                                    <p class="text-xs text-gray-500">Carrying Chemical</p>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Item 3 -->
                        <div class="p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-gray-800">F 9832 JNK</h4>
                                    </div>
                                    <p class="text-xs text-gray-500">Carrying Chemical</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const leftBar = document.getElementById('leftBar');

            sidebar.classList.toggle('-translate-x-full');

            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
                localStorage.setItem('sidebarOpen', 'false');
            } else {
                leftBar.style.transform = 'translateX(-100%)';
                overlay.classList.remove('hidden');
                localStorage.setItem('sidebarOpen', 'true');
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const leftBar = document.getElementById('leftBar');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            localStorage.setItem('sidebarOpen', 'false');

            setTimeout(() => {
                leftBar.style.transform = 'translateX(0)';
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebarOpen = localStorage.getItem('sidebarOpen');

            if (sidebarOpen === 'true') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                const leftBar = document.getElementById('leftBar');

                sidebar.classList.remove('-translate-x-full');
                leftBar.style.transform = 'translateX(-100%)';
                overlay.classList.remove('hidden');
            }
        });
    </script>
</body>

</html>