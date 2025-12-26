<!-- Title & Add Button -->
<div class="p-4 border-b border-gray-200 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Fleet & Device</h2>
        <p class="text-xs text-gray-500">Manager Center / Fleet & Device</p>
    </div>
    <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-600 rounded-lg text-white px-4 py-2 rounded text-sm flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Add New Fleet</span>
    </button>
</div>

<!-- Filter Section -->
<div class="ps-4 pe-4 pt-4 border-b border-gray-200 bg-orange-50">
    <!-- Header (Toggle) -->
    <button
        type="button"
        onclick="toggleFilter()"
        class="w-full flex items-center justify-between mb-3 focus:outline-none">
        <h3 class="font-bold text-gray-800">Filter</h3>
        <svg
            id="filterArrow"
            class="w-5 h-5 text-gray-600 transition-transform duration-300"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Collapsible Content -->
    <div
        id="filterContent"
        class="overflow-hidden transition-all duration-300 max-h-96 opacity-100">
        <!-- Filter Pills -->
        <div class="flex flex-wrap gap-2 mb-4">
            <button
                class="px-3 py-1.5 bg-white border border-gray-200 rounded-sm text-xs text-gray-700
                hover:bg-gray-100 hover:border-gray-300 transition">
                Unassigned
            </button>

            <button
                class="px-3 py-1.5 bg-white border border-gray-200 rounded-sm text-xs text-gray-700
                hover:bg-gray-100 hover:border-gray-300 transition">
                Assigned
            </button>

            <button
                class="px-3 py-1.5 bg-white border border-gray-200 rounded-sm text-xs text-gray-700
                hover:bg-gray-100 hover:border-gray-300 transition">
                En Route
            </button>

            <button
                class="px-3 py-1.5 bg-white border border-gray-200 rounded-sm text-xs text-gray-700
                hover:bg-gray-100 hover:border-gray-300 transition">
                Active
            </button>

            <button
                class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-xs text-gray-700
                hover:bg-gray-100 hover:border-gray-300 transition">
                Inactive
            </button>

            <!-- Active -->
            <button
                class="px-3 py-1.5 bg-orange-200 border border-orange-300 rounded-full
                   text-xs text-orange-800 font-medium">
                All
            </button>
        </div>

    </div>

</div>

<!-- Script (ringan & aman) -->
<script>
    let filterOpen = true;

    function toggleFilter() {
        const content = document.getElementById('filterContent');
        const arrow = document.getElementById('filterArrow');

        filterOpen = !filterOpen;

        if (filterOpen) {
            content.classList.remove('max-h-0', 'opacity-0');
            content.classList.add('max-h-96', 'opacity-100');
            arrow.classList.remove('rotate-180');
        } else {
            content.classList.remove('max-h-96', 'opacity-100');
            content.classList.add('max-h-0', 'opacity-0');
            arrow.classList.add('rotate-180');
        }
    }
</script>