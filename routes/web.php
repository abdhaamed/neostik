<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FleetDeviceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DriverTaskController;
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
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin-dashboard.dashboard');
    })->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile');
    Route::put('/profile/update', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');

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

        /*
        |--------------------------------------------------------------------------
        | TASK ASSIGNMENT
        |--------------------------------------------------------------------------
        */
        Route::post('/tasks', [TaskController::class, 'assign'])
            ->name('manager.tasks.store');

        /*
        |--------------------------------------------------------------------------
        | FLEET ACCEPTANCE (BARU)
        |--------------------------------------------------------------------------
        */
        Route::post('/fleet/{fleet}/accept', [FleetDeviceController::class, 'acceptCompleted'])
            ->name('manager.fleet.accept');

        /*
        |--------------------------------------------------------------------------
        | DEVICE HISTORY
        |--------------------------------------------------------------------------
        */
        Route::post('/device/{id}/history', [FleetDeviceController::class, 'addDeviceHistory'])
            ->name('manager.device.history.store');

        Route::get('/device/{id}/histories', [FleetDeviceController::class, 'getDeviceHistories'])
            ->name('manager.device.histories');

        /*
        |--------------------------------------------------------------------------
        | USER MANAGEMENT
        |--------------------------------------------------------------------------
        */
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
        Route::get('/route-history', function () {
            return view('admin-dashboard.report.route-history');
        })->name('report.route-history');

        Route::get('/operational-report', function () {
            return view('admin-dashboard.report.operational-report');
        })->name('report.operational-report');
    });

    /*
    |--------------------------------------------------------------------------
    | COMMAND CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('command')->group(function () {
        Route::get('/message', function () {
            return view('admin-dashboard.command.message');
        })->name('command.message');

        Route::get('/broadcast', function () {
            return view('admin-dashboard.command.broadcast');
        })->name('command.broadcast');
    });

    Route::get('/audit-logs', function () {
        return view('admin-dashboard.audit-logs');
    })->name('audit-logs');

    Route::get('/alert', function () {
        return view('admin-dashboard.alert');
    })->name('alert');
});

/*
|--------------------------------------------------------------------------
| DRIVER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DriverController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/shipments', [App\Http\Controllers\DriverController::class, 'shipments'])->name('driver.shipments');
    
    Route::get('/tasks/{task}', [DriverTaskController::class, 'show'])->name('driver.tasks.show');
    Route::post('/tasks/{task}/enroute', [DriverTaskController::class, 'submitEnRouteEvidence'])->name('driver.tasks.enroute');
    Route::post('/tasks/{task}/complete', [DriverTaskController::class, 'submitCompletedEvidence'])->name('driver.tasks.complete');
    
    Route::get('/profile', [App\Http\Controllers\DriverController::class, 'profile'])->name('driver.profile');
    Route::put('/profile/update', [App\Http\Controllers\DriverController::class, 'updateProfile'])->name('driver.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\DriverController::class, 'updatePassword'])->name('driver.profile.password');
    Route::put('/profile/vehicle', [App\Http\Controllers\DriverController::class, 'updateVehicle'])->name('driver.profile.vehicle');
});