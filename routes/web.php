<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

// Manager Center
Route::prefix('manager')->group(function () {
    Route::get('/fleet-device', function () {
        return view('pages.manager.fleet-device');
    })->name('manager.fleet-device');

    Route::get('/user-management', function () {
        return view('pages.manager.user-management');
    })->name('manager.user-management');
});

// Report Center
Route::prefix('report')->group(function () {
    Route::get('/route-history', function () {
        return view('pages.report.route-history');
    })->name('report.route-history');

    Route::get('/operational-report', function () {
        return view('pages.report.operational-report');
    })->name('report.operational-report');
});

// Command
Route::prefix('command')->group(function () {
    Route::get('/message', function () {
        return view('pages.command.message');
    })->name('command.message');

    Route::get('/broadcast', function () {
        return view('pages.command.broadcast');
    })->name('command.broadcast');
});

// Audit Logs
Route::get('/audit-logs', function () {
    return view('pages.audit-logs');
})->name('audit-logs');

// Alert
Route::get('/alert', function () {
    return view('pages.alert');
})->name('alert');
