<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login');
Route::view('/login', 'auth.login')->name('login');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});

Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard');
    Route::view('/tenants', 'admin.tenants');
    Route::view('/rooms', 'admin.rooms');
    Route::view('/payments', 'admin.payments');
    Route::view('/calendar', 'admin.calendar');
    Route::view('/reports', 'admin.reports');
    Route::view('/users', 'admin.users');
    Route::view('/profile', 'admin.profile');
});

Route::prefix('tenant')->group(function () {
    Route::view('/dashboard', 'tenant.dashboard');
    Route::view('/calendar', 'tenant.calendar');
    Route::view('/payment', 'tenant.payment');
    Route::view('/reports', 'tenant.reports');
    Route::view('/profile', 'tenant.profile');
});