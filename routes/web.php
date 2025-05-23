<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\historyController;
use App\Http\Controllers\chartController;
use App\Http\Controllers\kategoriController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('web');


Route::middleware('auth')->group(function(){

    //Chart data
    Route::get('/chart-data', [chartController::class, 'getChartData'])->name('chart-data');
    Route::get('/expense-data', [chartController::class, 'getExpenseData'])->name('expense-data');
    Route::get('/income-data', [chartController::class, 'getIncomeData'])->name('income-data');

    //Kategori
    Route::get('/kategori', [kategoriController::class, 'create'])->name('kategori');
    Route::post('/kategori', [kategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [kategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [kategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [kategoriController::class, 'destroy'])->name('kategori.delete');

    //Dashboard
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    //history
    Route::get('/transaksi/history', [historyController::class, 'index'])->name('transaksi.history');

    //Transaksi
    Route::get('/transaksi/create', [transaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [transaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}/edit', [transaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [transaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [transaksiController::class, 'destroy'])->name('transaksi.delete');
});

Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
