<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FleetDeviceController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Driver\DriverController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'choice'])->name('login');

// Admin login
Route::get('/login/admin', [LoginController::class, 'adminForm'])->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'adminLogin'])->name('login.admin.post');

// Driver login
Route::get('/login/driver', [LoginController::class, 'driverForm'])->name('login.driver');
Route::post('/login/driver', [LoginController::class, 'driverLogin'])->name('login.driver.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA (ADMIN ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Tambahkan routes ini di dalam middleware admin
    Route::get('/dashboard/fleet/{id}', [DashboardController::class, 'getFleetDetail'])
        ->name('dashboard.fleet.detail');

    Route::get('/dashboard/gps-data', [DashboardController::class, 'getGpsData'])
        ->name('dashboard.gps');

    Route::get('/dashboard/route-history/{fleet}', [DashboardController::class, 'getRouteHistory'])
        ->name('dashboard.route.history');

    /*
    |--------------------------------------------------------------------------
    | MANAGER CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('manager')->group(function () {

        Route::get('/fleet-device', [FleetDeviceController::class, 'index'])
            ->name('manager.fleet-device');

        // AJAX endpoints
        Route::get('/fleet-device/fleet/{id}', [FleetDeviceController::class, 'getFleetDetail'])
            ->name('manager.fleet-device.fleet-detail');

        Route::get('/fleet-device/device/{fleet}', [FleetDeviceController::class, 'getDeviceDetail'])
            ->name('manager.fleet-device.device-detail');

        // Fleet CRUD
        Route::post('/fleet-device/fleet', [FleetDeviceController::class, 'store'])
            ->name('manager.fleet-device.store');

        Route::put('/fleet-device/fleet/{id}', [FleetDeviceController::class, 'update'])
            ->name('manager.fleet-device.update');

        Route::delete('/fleet-device/fleet/{id}', [FleetDeviceController::class, 'destroy'])
            ->name('manager.fleet-device.destroy');

        // Device Management
        Route::post('/fleet-device/device/{fleet}', [FleetDeviceController::class, 'assignDevice'])
            ->name('manager.fleet-device.assign-device');

        Route::put('/fleet-device/device/{device}', [FleetDeviceController::class, 'updateDevice'])
            ->name('manager.fleet-device.update-device');

        Route::delete('/fleet-device/device/{device}', [FleetDeviceController::class, 'removeDevice'])
            ->name('manager.fleet-device.remove-device');



        Route::get('/user-management', [UserManagementController::class, 'index'])
            ->name('manager.user-management');

        // Driver CRUD
        Route::get('/user-management/driver/{id}', [UserManagementController::class, 'getDriverDetail'])
            ->name('manager.user-management.driver-detail');

        Route::post('/user-management/driver', [UserManagementController::class, 'store'])
            ->name('manager.user-management.store');

        Route::put('/user-management/driver/{id}', [UserManagementController::class, 'update'])
            ->name('manager.user-management.update');

        Route::put('/user-management/driver/{id}/password', [UserManagementController::class, 'updatePassword'])
            ->name('manager.user-management.update-password');

        Route::put('/user-management/driver/{id}/availability', [UserManagementController::class, 'updateAvailability'])
            ->name('manager.user-management.update-availability');

        Route::delete('/user-management/driver/{id}', [UserManagementController::class, 'destroy'])
            ->name('manager.user-management.destroy');

        // Task History
        Route::get('/user-management/driver/{id}/tasks', [UserManagementController::class, 'getTaskHistory'])
            ->name('manager.user-management.task-history');

        // Assignment Requests
        Route::get('/user-management/assignments', [UserManagementController::class, 'getAssignmentRequests'])
            ->name('manager.user-management.assignments');

        Route::post('/user-management/assignments/{task}/approve', [UserManagementController::class, 'approveAssignment'])
            ->name('manager.user-management.approve-assignment');

        Route::post('/user-management/assignments/{task}/reject', [UserManagementController::class, 'rejectAssignment'])
            ->name('manager.user-management.reject-assignment');
    });

    /*
    |--------------------------------------------------------------------------
    | REPORT CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('report')->group(function () {

        Route::get('/route-history', function () {
            return view('pages.report.route-history');
        })->name('report.route-history');

        Route::get('/operational-report', function () {
            return view('pages.report.operational-report');
        })->name('report.operational-report');
    });

    /*
    |--------------------------------------------------------------------------
    | COMMAND CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('command')->group(function () {

        Route::get('/message', function () {
            return view('pages.command.message');
        })->name('command.message');

        Route::get('/broadcast', function () {
            return view('pages.command.broadcast');
        })->name('command.broadcast');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN OTHERS
    |--------------------------------------------------------------------------
    */
    Route::get('/audit-logs', function () {
        return view('pages.audit-logs');
    })->name('audit-logs');

    Route::get('/alert', function () {
        return view('pages.alert');
    })->name('alert');
});


/*
|--------------------------------------------------------------------------
| DRIVER AREA (DRIVER ONLY)
|--------------------------------------------------------------------------
*/

Route::prefix('driver')->middleware(['auth', 'role:driver'])->name('driver.')->group(function () {

    // Dashboard - Main page with stats and available tasks
    Route::get('/dashboard', [DriverController::class, 'dashboard'])
        ->name('dashboard');

    // Available Tasks - Browse all tasks that can be claimed
    Route::get('/available-tasks', [DriverController::class, 'availableTasks'])
        ->name('available.tasks');

    // Claim Task - Driver takes ownership of a task
    Route::post('/task/{id}/claim', [DriverController::class, 'claimTask'])
        ->name('task.claim');

    // My Shipments - List of all driver's tasks (claimed, ongoing, completed)
    Route::get('/shipments', [DriverController::class, 'shipments'])
        ->name('shipments');

    // Task Detail - View detailed information about a specific task
    Route::get('/task/{id}', [DriverController::class, 'taskDetail'])
        ->name('task.detail');

    // Start Task - Begin the delivery (change status from assigned to approved)
    Route::post('/task/{id}/start', [DriverController::class, 'startTask'])
        ->name('task.start');

    // Complete Task - Finish delivery with evidence photo and recipient info
    Route::post('/task/{id}/complete', [DriverController::class, 'completeTask'])
        ->name('task.complete');

    // Cancel Task - Return task to available pool (from assigned back to pending)
    Route::post('/task/{id}/cancel', [DriverController::class, 'cancelTask'])
        ->name('task.cancel');

    // Upload Cost - Add operational expenses during delivery
    Route::post('/task/{id}/cost', [DriverController::class, 'uploadCost'])
        ->name('task.cost');
});