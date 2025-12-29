@php
$currentRoute = Route::currentRouteName();
@endphp

<!-- Logo -->
<div>
    <div class="flex justify-center items-center mb-2">
        <div class="w-full h-12 flex justify-center items-center">
            <img src="{{ asset('images/NEOSTIK.png') }}" alt="NEOSTIK Logo" class="max-h-full max-w-full object-contain">
        </div>
    </div>

    <!-- Menu -->
    <ul class="space-y-2">
        <!-- Dashboard -->
        <li class="flex items-center p-2 rounded hover:bg-orange-100 cursor-pointer {{ $currentRoute === 'dashboard' ? 'bg-orange-50 font-semibold' : '' }}">
            <a href="{{ route('dashboard') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"></svg>
                Dashboard
            </a>
        </li>

        <!-- Manager Center -->
        @php $managerOpen = in_array($currentRoute, ['manager.fleet-device','manager.user-management']); @endphp
        <li>
            <button class="flex items-center justify-between w-full p-2 rounded hover:bg-orange-100 cursor-pointer" onclick="toggleMenu('manager')">
                <span class="flex items-center">
                    <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"></svg>
                    Manager Center
                </span>
                <svg class="w-4 h-4 text-gray-600 transform transition-transform duration-300" id="icon-manager" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul id="manager" class="ml-10 mt-1 overflow-hidden transition-all duration-300 ease-in-out border-l-2 border-orange-300 text-sm {{ $managerOpen ? 'max-h-[500px]' : 'max-h-0' }}">
                <a href="{{ route('manager.fleet-device') }}">
                    <li class="m-2 p-2 rounded hover:bg-orange-50 cursor-pointer {{ $currentRoute === 'manager.fleet-device' ? 'bg-orange-50 font-semibold' : '' }}">Fleet & Device</li>
                </a>
                <a href="{{ route('manager.user-management') }}">
                    <li class="m-2 p-2 rounded hover:bg-orange-50 cursor-pointer {{ $currentRoute === 'manager.user-management' ? 'bg-orange-50 font-semibold' : '' }}">User Management</li>
                </a>
            </ul>
        </li>

        <!-- Report Center -->
        @php $reportOpen = in_array($currentRoute, ['report.route-history','report.operational-report']); @endphp
        <li>
            <button class="flex items-center justify-between w-full p-2 rounded hover:bg-orange-100 cursor-pointer" onclick="toggleMenu('report')">
                <span class="flex items-center">
                    <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"></svg>
                    Report Center
                </span>
                <svg class="w-4 h-4 text-gray-600 transform transition-transform duration-300" id="icon-report" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul id="report" class="ml-10 mt-1 overflow-hidden transition-all duration-300 ease-in-out border-l-2 border-orange-300 text-sm {{ $reportOpen ? 'max-h-[500px]' : 'max-h-0' }}">
                <a href="{{ route('report.route-history') }}">
                    <li class="m-2 p-2 rounded hover:bg-orange-50 cursor-pointer {{ $currentRoute === 'report.route-history' ? 'bg-orange-50 font-semibold' : '' }}">Route History</li>
                </a>
                <a href="{{ route('report.operational-report') }}">
                    <li class="m-2 p-2 rounded hover:bg-orange-50 cursor-pointer {{ $currentRoute === 'report.operational-report' ? 'bg-orange-50 font-semibold' : '' }}">Operational Report</li>
                </a>
            </ul>
        </li>

        <!-- Audit Logs -->
        <li class="flex items-center p-2 rounded hover:bg-orange-100 cursor-pointer {{ $currentRoute === 'audit-logs' ? 'bg-orange-50 font-semibold' : '' }}">
            <a href="{{ route('audit-logs') }}" class="flex items-center w-full">
                <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"></svg>
                Audit Logs
            </a>
        </li>

    </ul>
</div>

<script>
    function toggleMenu(id) {
        const menu = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        const isOpen = menu.classList.contains('max-h-[500px]');

        if (isOpen) {
            menu.classList.remove('max-h-[500px]');
            menu.classList.add('max-h-0');
        } else {
            menu.classList.remove('max-h-0');
            menu.classList.add('max-h-[500px]');
        }

        icon.classList.toggle('rotate-180');
    }
</script>