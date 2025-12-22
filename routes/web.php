<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FleetDeviceController;

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

    /*
    |--------------------------------------------------------------------------
    | MANAGER CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('manager')->group(function () {

        Route::get('/fleet-device', [FleetDeviceController::class, 'index'])
            ->name('manager.fleet-device');

        Route::get('/user-management', function () {
            return view('pages.manager.user-management');
        })->name('manager.user-management');
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

Route::prefix('driver')->middleware(['auth', 'role:driver'])->group(function () {

    Route::get('/dashboard', function () {
        return view('driver.dashboard');
    })->name('driver.dashboard');

    Route::get('/shipments', function () {
        return view('driver.shipments');
    })->name('driver.shipments');
});
