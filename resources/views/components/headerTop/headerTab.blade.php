<!-- Header Top -->
<div class="flex items-center bg-[#FFCD99] px-4 pt-2 -mx-4 -mt-2 shadow">
    <!-- Tabs Container -->
    <div class="flex space-x-1 overflow-x-auto max-w-5xl" id="tabsContainer">
        <!-- Tabs will be dynamically inserted here -->
    </div>

    <!-- Dropdown -->
    <button class="ml-auto text-gray-600 hover:text-gray-800 focus:outline-none self-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
</div>

<style>
    .tab-item {
        transition: all 0.2s ease;
        position: relative;
    }

    .tab-item:hover {
        background-color: #f9fafb;
    }

    .tab-item.active-tab {
        background-color: #ffffff;
        border-color: #fb923c;
        box-shadow: 0 -2px 8px rgba(251, 146, 60, 0.15);
    }

    .tab-item:not(.active-tab) {
        opacity: 0.7;
    }

    #tabsContainer {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    #tabsContainer::-webkit-scrollbar {
        height: 4px;
    }

    #tabsContainer::-webkit-scrollbar-track {
        background: transparent;
    }

    #tabsContainer::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 2px;
    }
</style>

<script>
    // Tab Management System
    let tabs = [];
    let activeTabId = 'welcome';

    // Initialize with welcome tab

    // Create new vehicle tab
    function createVehicleTab(plateNumber, cargo, driverName, latitude = null, longitude = null) {
        const tabId = `vehicle-${plateNumber.replace(/\s/g, '-')}`;

        // Check if tab already exists
        const existingTab = tabs.find(tab => tab.id === tabId);
        if (existingTab) {
            // Switch to existing tab
            switchToTab(tabId);
            return;
        }

        // Create new tab
        const tab = {
            id: tabId,
            title: plateNumber,
            type: 'vehicle',
            data: {
                plateNumber: plateNumber,
                cargo: cargo,
                driverName: driverName,
                latitude: latitude,
                longitude: longitude
            }
        };

        tabs.push(tab);
        renderTabs();
        switchToTab(tabId);

        // TODO: Navigate to coordinates on map
        if (latitude && longitude) {
            console.log(`Navigate to: ${latitude}, ${longitude}`);
            // navigateToCoordinates(latitude, longitude);
        }
    }

    // Render all tabs
    function renderTabs() {
        const container = document.getElementById('tabsContainer');
        container.innerHTML = '';

        tabs.forEach(tab => {
            const tabElement = document.createElement('div');
            tabElement.setAttribute('data-tab-id', tab.id);
            tabElement.className = `tab-item bg-white w-40 px-3 py-1.5 rounded-t-lg border border-b-0 border-orange-300 flex items-center space-x-2 text-xs justify-between shadow cursor-pointer ${tab.id === activeTabId ? 'active-tab' : ''}`;

            tabElement.innerHTML = `
                <span class="font-medium truncate" title="${tab.title}">${tab.title}</span>
                ${tab.type !== 'default' ? `
                    <button onclick="closeTab(event, '${tab.id}')" class="text-gray-400 hover:text-gray-600 p-1 rounded focus:outline-none hover:bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                ` : `
                    <button onclick="closeTab(event, '${tab.id}')" class="text-gray-400 hover:text-gray-600 p-1 rounded focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `}
            `;

            // Add click event to switch tab
            tabElement.addEventListener('click', (e) => {
                // Don't switch if clicking close button
                if (!e.target.closest('button')) {
                    switchToTab(tab.id);
                }
            });

            container.appendChild(tabElement);
        });

        // Scroll to active tab
        scrollToActiveTab();
    }

    // Switch to specific tab
    function switchToTab(tabId) {
        activeTabId = tabId;

        // Update tab UI
        document.querySelectorAll('.tab-item').forEach(item => {
            if (item.getAttribute('data-tab-id') === tabId) {
                item.classList.add('active-tab');
            } else {
                item.classList.remove('active-tab');
            }
        });

        // Get tab data
        const tab = tabs.find(t => t.id === tabId);
        if (tab && tab.type === 'vehicle') {
            // Show fleet detail
            showFleetDetail(tab.data.plateNumber, tab.data.cargo, tab.data.driverName);

            // Navigate to coordinates if available
            if (tab.data.latitude && tab.data.longitude) {
                console.log(`Navigate to: ${tab.data.latitude}, ${tab.data.longitude}`);
                // navigateToCoordinates(tab.data.latitude, tab.data.longitude);
            }
        } else {
            // Close fleet detail for welcome tab
            closeFleetDetail();
        }

        // Save to session storage
        sessionStorage.setItem('activeTab', tabId);
        sessionStorage.setItem('tabs', JSON.stringify(tabs));
    }

    // Close tab
    function closeTab(event, tabId) {
        event.stopPropagation();

        const tabIndex = tabs.findIndex(t => t.id === tabId);
        if (tabIndex === -1) return;

        tabs.splice(tabIndex, 1);

        // Kalau masih ada tab, tentukan activeTab
        if (tabs.length > 0) {
            if (tabId === activeTabId) {
                const newActiveTab = tabs[Math.max(0, tabIndex - 1)];
                activeTabId = newActiveTab.id;
            }
            renderTabs();
            switchToTab(activeTabId);
        } else {
            // kalau sudah kosong semua
            activeTabId = null;
            renderTabs();
            sessionStorage.removeItem('activeTab');
            sessionStorage.removeItem('tabs');
            closeFleetDetail(); // biar konten bersih
        }
    }


    // Add manual tab (for + button)
    function addManualTab() {
        const tabCount = tabs.filter(t => t.type === 'manual').length;
        const tabId = `manual-${Date.now()}`;

        const tab = {
            id: tabId,
            title: `New Tab ${tabCount + 1}`,
            type: 'manual',
            data: null
        };

        tabs.push(tab);
        renderTabs();
        switchToTab(tabId);
    }

    // Scroll to active tab
    function scrollToActiveTab() {
        const container = document.getElementById('tabsContainer');
        const activeTab = container.querySelector('.active-tab');

        if (activeTab && container) {
            const containerRect = container.getBoundingClientRect();
            const tabRect = activeTab.getBoundingClientRect();

            if (tabRect.right > containerRect.right) {
                container.scrollLeft += tabRect.right - containerRect.right + 20;
            } else if (tabRect.left < containerRect.left) {
                container.scrollLeft -= containerRect.left - tabRect.left + 20;
            }
        }
    }

    // Load tabs from session storage on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedTabs = sessionStorage.getItem('tabs');
        const savedActiveTab = sessionStorage.getItem('activeTab');

        if (savedTabs) {
            tabs = JSON.parse(savedTabs);
            if (savedActiveTab) {
                activeTabId = savedActiveTab;
            }
            renderTabs();
            switchToTab(activeTabId);
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(event) {
        // Ctrl/Cmd + W to close tab
        if ((event.ctrlKey || event.metaKey) && event.key === 'w') {
            event.preventDefault();
            if (tabs.length > 1) {
                closeTab(event, activeTabId);
            }
        }

        // Ctrl/Cmd + T to add new tab
        if ((event.ctrlKey || event.metaKey) && event.key === 't') {
            event.preventDefault();
            addManualTab();
        }

        // Ctrl/Cmd + Tab to switch tabs
        if ((event.ctrlKey || event.metaKey) && event.key === 'Tab') {
            event.preventDefault();
            const currentIndex = tabs.findIndex(t => t.id === activeTabId);
            const nextIndex = event.shiftKey ?
                (currentIndex - 1 + tabs.length) % tabs.length :
                (currentIndex + 1) % tabs.length;
            switchToTab(tabs[nextIndex].id);
        }
    });
</script>