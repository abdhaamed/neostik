<div class="bg-white border-b border-gray-200 p-4 flex items-center justify-between">
    <div class="flex items-center space-x-3">
        <span class="text-sm font-medium text-gray-700">HD-23818981289</span>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
        </svg>
        <span class="flex items-center text-sm text-green-600">
            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
            En Route
        </span>
    </div>
</div>

<!-- Tabs -->
<div class="bg-white border-b border-gray-200 flex">
    <button class="tab-button px-6 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600" data-tab="fleet">Fleet</button>
    <button class="tab-button px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-800" data-tab="device">Device</button>
</div>

<!-- Fleet Detail -->
<div id="contentFleet" class="tab-content p-4">
    @include('components.pageContent.fleetDevice.detail.fleet')
</div>

<!-- Device Detail -->
<div id="contentDevice" class="tab-content hidden p-4">
    @include('components.pageContent.fleetDevice.detail.device')
</div>
