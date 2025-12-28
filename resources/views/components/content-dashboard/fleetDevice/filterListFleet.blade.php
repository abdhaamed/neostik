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