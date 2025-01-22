<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksiController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [transaksiController::class, 'index'])->name('dashboard');
    Route::get('/transaksi/history', [transaksiController::class, 'history'])->name('transaksi.history');
    Route::get('/transaksi/create', [transaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [transaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}/edit', [transaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [transaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [transaksiController::class, 'delete'])->name('transaksi.delete');
});

Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
