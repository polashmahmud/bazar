<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'demo'], function () {
    Route::get('/', function () {
        return Inertia::render('demo/Home');
    })->name('demo.home');

    Route::get('/create', function () {
        return Inertia::render('demo/Create');
    })->name('demo.create');

    Route::get('/list', function () {
        return Inertia::render('demo/List');
    })->name('demo.list');
});

require __DIR__.'/settings.php';
