<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('dashboard-api', 'dashboard-api')
        ->name('dashboard-api');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::view('admin', 'admin')
        ->name('admin');

});

require __DIR__.'/auth.php';
