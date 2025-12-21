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