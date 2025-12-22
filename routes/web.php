<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

// Halaman pilihan login (Login Choice) - route wajib bernama 'login' agar middleware auth bekerja
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
| DASHBOARDS
|--------------------------------------------------------------------------
*/

// Admin dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('auth')->name('dashboard');

// Driver dashboard
Route::get('/driver/dashboard', function () {
    return view('driver.dashboard');
})->middleware('auth')->name('driver.dashboard');


/*
|--------------------------------------------------------------------------
| MANAGER CENTER
|--------------------------------------------------------------------------
*/

Route::prefix('manager')->middleware('auth')->group(function () {

    Route::get('/fleet-device', function () {
        return view('pages.manager.fleet-device');
    })->name('manager.fleet-device');

    Route::get('/user-management', function () {
        return view('pages.manager.user-management');
    })->name('manager.user-management');

});


/*
|--------------------------------------------------------------------------
| REPORT CENTER
|--------------------------------------------------------------------------
*/

Route::prefix('report')->middleware('auth')->group(function () {

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

Route::prefix('command')->middleware('auth')->group(function () {

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
})->middleware('auth')->name('audit-logs');

Route::get('/alert', function () {
    return view('pages.alert');
})->middleware('auth')->name('alert');


// DRIVER dashboard & shipments
Route::prefix('driver')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('driver.dashboard');
    })->name('driver.dashboard');

    Route::get('/shipments', function () {
        return view('driver.shipments');
    })->name('driver.shipments');
});
