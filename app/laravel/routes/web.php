<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('customers.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/customers/create', [CustomerController::class, 'create'])
        ->middleware('role:admin')
        ->name('customers.create');

    Route::post('/customers', [CustomerController::class, 'store'])
        ->middleware('role:admin')
        ->name('customers.store');

    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
        ->middleware('role:admin')
        ->name('customers.edit');

    Route::put('/customers/{customer}', [CustomerController::class, 'update'])
        ->middleware('role:admin')
        ->name('customers.update');

    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('customers.destroy');

    Route::get('/customers/statistics', [CustomerController::class, 'statistics'])
        ->name('customers.statistics');
    
    Route::get('/customers/delete-complete',[CustomerController::class, 'deleteComplete'])       
        ->name('customers.deleteComplete');
        
});

require __DIR__.'/auth.php';
