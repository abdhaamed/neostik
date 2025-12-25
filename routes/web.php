<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
// Halaman pilihan login (Login Choice)
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
    // Admin dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    // Admin Profile
    Route::get('/profile', [App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile');
    Route::put('/profile/update', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');

    /*
    |--------------------------------------------------------------------------
    | MANAGER CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('manager')->group(function () {
        Route::get('/fleet-device', function () {
            return view('pages.manager.fleet-device');
        })->name('manager.fleet-device');

        // User Management Routes
        Route::get('/user-management', [UserController::class, 'index'])->name('manager.user-management');
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
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
    | OTHERS
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
| DRIVER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DriverController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/shipments', [App\Http\Controllers\DriverController::class, 'shipments'])->name('driver.shipments');
    Route::get('/profile', [App\Http\Controllers\DriverController::class, 'profile'])->name('driver.profile');
    
    // Profile Updates
    Route::put('/profile/update', [App\Http\Controllers\DriverController::class, 'updateProfile'])->name('driver.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\DriverController::class, 'updatePassword'])->name('driver.profile.password');
    Route::put('/profile/vehicle', [App\Http\Controllers\DriverController::class, 'updateVehicle'])->name('driver.profile.vehicle');
});