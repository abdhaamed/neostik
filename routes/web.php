<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FleetDeviceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DriverTaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController; // ✅ Hanya butuh ini
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'choice'])->name('login');

Route::get('/login/admin', [LoginController::class, 'adminForm'])->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'adminLogin'])->name('login.admin.post');

Route::get('/login/driver', [LoginController::class, 'driverForm'])->name('login.driver');
Route::post('/login/driver', [LoginController::class, 'driverLogin'])->name('login.driver.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('driver.dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (HANYA SATU BLOK!)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/api/fleets', [FleetDeviceController::class, 'apiGetFleets']);
    Route::get('/api/fleets/{fleet}/task', [FleetDeviceController::class, 'apiGetFleetTask']);
});

Route::middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // PROFILE
    Route::get('/profile', [App\Http\Controllers\AdminProfileController::class, 'show'])
        ->name('admin.profile');
    Route::put('/profile/update', [App\Http\Controllers\AdminProfileController::class, 'update'])
        ->name('admin.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\AdminProfileController::class, 'updatePassword'])
        ->name('admin.profile.password');

    /*
    |--------------------------------------------------------------------------
    | MANAGER CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('manager')->group(function () {
        Route::get('/fleet-device', [FleetDeviceController::class, 'index'])
            ->name('manager.fleet-device');

        Route::post('/fleet-device', [FleetDeviceController::class, 'store'])
            ->name('manager.fleet-device.store');

        Route::post('/tasks', [TaskController::class, 'assign'])
            ->name('manager.tasks.store');

        Route::post('/fleet/{fleet}/accept', [FleetDeviceController::class, 'acceptCompleted'])
            ->name('manager.fleet.accept');

        Route::post('/device/{id}/history', [FleetDeviceController::class, 'addDeviceHistory'])
            ->name('manager.device.history.store');

        Route::get('/device/{id}/histories', [FleetDeviceController::class, 'getDeviceHistories'])
            ->name('manager.device.histories');

        Route::get('/user-management', [UserController::class, 'index'])
            ->name('manager.user-management');

        Route::get('/users/search', [UserController::class, 'search'])
            ->name('users.search');

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('users.show');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | REPORT CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('report')->group(function () {
        Route::get('/route-history', [ReportController::class, 'routeHistory'])
            ->name('report.route-history');

        Route::get('/operational-report', [ReportController::class, 'operationalReport'])
            ->name('report.operational-report');
    });

    /*
    |--------------------------------------------------------------------------
    | COMMAND CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('command')->group(function () {
        Route::get('/message', [AdminController::class, 'message'])
            ->name('command.message');

        Route::get('/broadcast', [AdminController::class, 'broadcast'])
            ->name('command.broadcast');
    });

    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])
        ->name('audit-logs');

    Route::get('/alert', [AdminController::class, 'alert'])
        ->name('alert');
});

/*
|--------------------------------------------------------------------------
| DRIVER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DriverController::class, 'dashboard'])
        ->name('driver.dashboard');
    Route::get('/shipments', [App\Http\Controllers\DriverController::class, 'shipments'])
        ->name('driver.shipments');

    Route::get('/tasks/{task}', [DriverTaskController::class, 'show'])
        ->name('driver.tasks.show');
    Route::post('/tasks/{task}/enroute', [DriverTaskController::class, 'submitEnRouteEvidence'])
        ->name('driver.tasks.enroute');
    Route::post('/tasks/{task}/complete', [DriverTaskController::class, 'submitCompletedEvidence'])
        ->name('driver.tasks.complete');

    Route::get('/profile', [App\Http\Controllers\DriverController::class, 'profile'])
        ->name('driver.profile');
    Route::put('/profile/update', [App\Http\Controllers\DriverController::class, 'updateProfile'])
        ->name('driver.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\DriverController::class, 'updatePassword'])
        ->name('driver.profile.password');
    Route::put('/profile/vehicle', [App\Http\Controllers\DriverController::class, 'updateVehicle'])
        ->name('driver.profile.vehicle');
});