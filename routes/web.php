<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroceryIndexController;
use App\Http\Controllers\GroceryListController;
use App\Http\Controllers\GrocerySearchController;
use App\Http\Controllers\HomeController;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::group(['middleware' => ['auth', 'ensure.gemini.key.set']], function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/groceries', GroceryIndexController::class);
    Route::get('/groceries-list', GroceryListController::class);
    Route::post('/groceries-list', [GroceryListController::class, 'store'])->name('groceries-list.store');
    Route::get('/grocery-search', GrocerySearchController::class);
});

Route::get('/lists', function () {
    $result = Gemini::generativeModel(model: 'gemini-2.0-flash')->generateContent('Hello');

    return $result->text(); // Hello! How can I assist you today?
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
