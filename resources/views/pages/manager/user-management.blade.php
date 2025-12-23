@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Left Bar - Always visible (Logo + Hamburger) -->
    @include('components.sidebar.humbergerButton')

    <!-- Sidebar - Default hidden -->
    <aside id="sidebar" class="w-64 bg-white text-gray-800 p-6 border-r border-gray-200 h-screen flex flex-col transform -translate-x-full transition-transform duration-300 fixed z-40 left-0">
        @include('components.sidebar.sidebar')
        @include('components.sidebar.profile')
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col" style="margin-left: 60px;">
        <header class="px-4 py-2">
            <!-- Header Top with Tabs -->
            @include('components.headerTop.headerTab')
            
            <!-- Status Badges -->
            @include('components.headerTop.badgeStatus', ['statistics' => $statistics])

            <!-- Breadcrumb and Action Buttons -->
            <div class="flex items-center justify-between m-6">
                <p class="text-sm text-gray-800">Driver Management / Status Board</p>
                <div class="flex items-center gap-3">
                    <!-- Driver Overview Button -->
                    <button class="page-button px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm transition-colors" data-page="statusboard">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Driver Overview
                    </button>

                    <!-- Assignment Request Panel Button -->
                    <button class="page-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 flex items-center gap-2 text-sm transition-colors" data-page="assignment">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Assignment Request Panel
                    </button>
                </div>
            </div>
        </header>

        <main class="flex-1 px-10 overflow-y-auto">
            <!-- Status Board Content (Default Active) -->
            <div id="contentStatusboard" class="page-content bg-white p-6 rounded shadow">
                @include('components.pageContent.userManagement.dataUser', ['drivers' => $drivers])
            </div>

            <!-- Assignment Request Panel Content (Hidden by default) -->
            <div id="contentAssignment" class="page-content bg-white p-6 rounded shadow hidden">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Assignment Request Panel</h2>
                
                <!-- Pending Tasks Table -->
                <div id="assignmentRequestsContainer">
                    <div class="text-center py-12 text-gray-400">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
                        <p>Loading assignment requests...</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // CSRF Token Setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.addEventListener('DOMContentLoaded', function() {
        // Page switching untuk Driver Overview dan Assignment Request Panel
        const pageButtons = document.querySelectorAll('.page-button');
        const pageContents = document.querySelectorAll('.page-content');

        pageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetPage = this.getAttribute('data-page');

                // Remove active state dari semua buttons
                pageButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });

                // Add active state ke button yang diklik
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-blue-600', 'text-white');

                // Hide semua content
                pageContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show content yang sesuai
                const targetId = 'content' + targetPage.charAt(0).toUpperCase() + targetPage.slice(1);
                const targetContent = document.getElementById(targetId);
                
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                    
                    // Load assignment requests jika tab assignment diklik
                    if (targetPage === 'assignment') {
                        loadAssignmentRequests();
                    }
                }
            });
        });
    });

    // Load Assignment Requests
    function loadAssignmentRequests() {
        const container = document.getElementById('assignmentRequestsContainer');
        
        fetch('/manager/user-management/assignments', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderAssignmentRequests(data.data);
            } else {
                showError('Failed to load assignment requests');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while loading assignment requests');
        });
    }

    // Render Assignment Requests Table
    function renderAssignmentRequests(tasks) {
        const container = document.getElementById('assignmentRequestsContainer');
        
        if (tasks.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-lg font-medium">No Pending Requests</p>
                    <p class="text-sm mt-2">All assignment requests have been processed</p>
                </div>
            `;
            return;
        }

        let tableHTML = `
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Task Number</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Driver</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Fleet</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Route</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Delivery Date</th>
                            <th class="text-center py-3 px-4 font-medium text-gray-600 text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        tasks.forEach(task => {
            tableHTML += `
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-4 px-4 text-sm text-gray-700 font-medium">${task.task_number}</td>
                    <td class="py-4 px-4 text-sm text-gray-700">${task.driver?.user?.name || '—'}</td>
                    <td class="py-4 px-4 text-sm text-gray-700">${task.fleet?.license_plate || '—'}</td>
                    <td class="py-4 px-4 text-sm text-gray-600">
                        <div>${task.origin}</div>
                        <div class="text-gray-400">→ ${task.destination}</div>
                    </td>
                    <td class="py-4 px-4 text-sm text-gray-700">${new Date(task.delivery_date).toLocaleDateString('id-ID')}</td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="approveAssignment(${task.id})" 
                                    class="px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600 transition-colors">
                                Approve
                            </button>
                            <button onclick="rejectAssignment(${task.id})" 
                                    class="px-3 py-1.5 bg-red-500 text-white rounded text-xs hover:bg-red-600 transition-colors">
                                Reject
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tableHTML += `
                    </tbody>
                </table>
            </div>
        `;

        container.innerHTML = tableHTML;
    }

    // Approve Assignment
    function approveAssignment(taskId) {
        if (!confirm('Are you sure you want to approve this assignment?')) {
            return;
        }

        fetch(`/manager/user-management/assignments/${taskId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Assignment approved successfully');
                loadAssignmentRequests(); // Reload table
            } else {
                alert('Failed to approve assignment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }

    // Reject Assignment
    function rejectAssignment(taskId) {
        const reason = prompt('Enter rejection reason (optional):');
        
        if (reason === null) return; // User clicked cancel

        fetch(`/manager/user-management/assignments/${taskId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Assignment rejected successfully');
                loadAssignmentRequests(); // Reload table
            } else {
                alert('Failed to reject assignment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }

    function showError(message) {
        const container = document.getElementById('assignmentRequestsContainer');
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <p class="text-gray-600 font-medium">${message}</p>
            </div>
        `;
    }
</script>
@endsection