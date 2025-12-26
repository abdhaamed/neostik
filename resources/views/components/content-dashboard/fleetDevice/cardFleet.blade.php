<div class="grid grid-cols-2 gap-4">

    <!-- Card -->
    <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition-all duration-200 cursor-pointer fleet-card"
        data-fleet-id="HD-99671212">
        <!-- Header -->
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-gray-800">HD-99671212</h4>
            <div class="flex items-center space-x-1">
                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                <span class="text-xs text-gray-600">Unassigned</span>
            </div>
        </div>

        <!-- Content Grid: Time | Timeline | Empty -->
        <div class="grid grid-cols-3 gap-4 mb-4">
            <!-- Left: Time Info -->
            <div class="flex flex-col">
                <span class="text-lg font-bold text-gray-800">09:23:21</span>
                <span class="text-xs text-gray-500 mt-1">28 min left</span>
            </div>

            <div class="flex flex-col space-y-2 relative pl-6">
                <!-- Vertical Line -->
                <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gray-300"></div>

                <!-- Status Items -->
                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full bg-green-500 border-2 border-white"></div>
                    <span class="text-xs text-gray-700">Completed</span>
                </div>

                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full bg-blue-500 border-2 border-white"></div>
                    <span class="text-xs text-gray-700">En Route</span>
                </div>

                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full bg-orange-500 border-2 border-white"></div>
                    <span class="text-xs text-gray-700">Assigned</span>
                </div>

                <div class="flex items-center space-x-2 relative z-10">
                    <div class="w-3 h-3 rounded-full bg-gray-400 border-2 border-white"></div>
                    <span class="text-xs text-gray-700">Unassigned</span>
                </div>
            </div>

            <!-- Right: Empty Space -->
            <div></div>
        </div>

        <!-- Truck Placeholder -->
        <div class="bg-gray-100 rounded h-24 flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
            </svg>
        </div>
    </div>

</div>