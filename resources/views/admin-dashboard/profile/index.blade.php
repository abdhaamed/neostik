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

            <!-- Breadcrumb -->
            <div class="m-6">
                <p class="text-sm text-gray-800">Settings / Profile</p>
            </div>
        </header>

        <main class="flex-1 px-10 overflow-y-auto">
            <div class="max-w-5xl mx-auto py-6">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Profile</h1>
                    <p class="text-gray-600">Manage your personal information and account settings</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Sidebar Navigation -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="flex flex-col items-center mb-6">
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-3">
                                    {{ $admin->initials }}
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $admin->name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $admin->email }}</p>
                                <span class="mt-2 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                    Administrator
                                </span>
                            </div>

                            <nav class="space-y-2">
                                <button onclick="showTab('personal')" data-tab="personal" class="tab-button w-full text-left px-4 py-3 rounded-lg font-medium transition-colors bg-blue-50 text-blue-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Personal Information</span>
                                    </div>
                                </button>
                                <button onclick="showTab('security')" data-tab="security" class="tab-button w-full text-left px-4 py-3 rounded-lg font-medium transition-colors text-gray-600 hover:bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        <span>Security</span>
                                    </div>
                                </button>
                                <a href="{{ route('dashboard') }}" class="block w-full text-left px-4 py-3 rounded-lg font-medium transition-colors text-gray-600 hover:bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        <span>Back to Dashboard</span>
                                    </div>
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Personal Information Tab -->
                        <div id="tabPersonal" class="tab-content bg-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-800">Personal Information</h2>
                                <span class="text-sm text-gray-500">Last updated: {{ $admin->updated_at->diffForHumans() }}</span>
                            </div>

                            <form id="formPersonal" onsubmit="updateProfile(event)">
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" name="name" value="{{ $admin->name }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                        <p class="text-xs text-gray-500 mt-1">This name will be displayed across the admin panel</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                        <div class="relative">
                                            <input type="email" value="{{ $admin->email }}" disabled
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Email cannot be changed for security reasons</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="text" name="phone" value="{{ $admin->phone }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="+62 812 3456 7890">
                                        <p class="text-xs text-gray-500 mt-1">Optional: For account recovery and notifications</p>
                                    </div>

                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-medium text-blue-800 mb-1">Account Information</h4>
                                                <p class="text-xs text-blue-700">
                                                    Your admin account has full access to all system features. Keep your credentials secure.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end gap-3">
                                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                                        Cancel
                                    </a>
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab -->
                        <div id="tabSecurity" class="tab-content bg-white rounded-lg shadow-lg p-6 hidden">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-800">Change Password</h2>
                                <span class="text-sm text-blue-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Secure
                                </span>
                            </div>

                            <form id="formPassword" onsubmit="updatePassword(event)">
                                <div class="space-y-6">
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-medium text-yellow-800 mb-1">Password Security Tips</h4>
                                                <ul class="text-xs text-yellow-700 space-y-1 list-disc list-inside">
                                                    <li>Use at least 6 characters</li>
                                                    <li>Include numbers and special characters</li>
                                                    <li>Don't reuse passwords from other accounts</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                        <input type="password" name="current_password" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="Enter your current password">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                        <input type="password" name="new_password" required minlength="6"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="Enter new password">
                                        <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" required minlength="6"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="Confirm new password">
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" onclick="document.getElementById('formPassword').reset()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                                        Reset Form
                                    </button>
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Tab switching
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remove active state from all buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('bg-blue-50', 'text-blue-600');
            btn.classList.add('text-gray-600');
        });

        // Show selected tab
        document.getElementById('tab' + tabName.charAt(0).toUpperCase() + tabName.slice(1)).classList.remove('hidden');

        // Add active state to clicked button
        const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
        if (activeBtn) {
            activeBtn.classList.add('bg-blue-50', 'text-blue-600');
            activeBtn.classList.remove('text-gray-600');
        }
    }

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 transform transition-all duration-300 z-50';

        const icon = type === 'success' ?
            '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
            '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

        toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <div>${icon}</div>
            <p class="text-gray-800 font-medium">${message}</p>
        </div>
    `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Update Profile
    function updateProfile(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Saving...';

        fetch('{{ route("admin.profile.update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    showToast(response.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(response.message, 'error');
                }
            })
            .catch(error => {
                showToast('Failed to update profile', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Save Changes';
            });
    }

    // Update Password
    function updatePassword(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Changing...';

        fetch('{{ route("admin.profile.password") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    showToast(response.message, 'success');
                    form.reset();
                } else {
                    showToast(response.message, 'error');
                }
            })
            .catch(error => {
                showToast('Failed to change password', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Change Password';
            });
    }
</script>
@endsection