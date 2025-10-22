<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::get('/lists', function () {
    return Inertia::render('List');
});

Route::get('/add', function () {
    return Inertia::render('Add');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
