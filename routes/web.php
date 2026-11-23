<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Public Pages
Route::get('/', [ItemController::class, 'home'])->name('home');
Route::get('/lost-items', [ItemController::class, 'lost'])->name('items.lost');
Route::get('/found-items', [ItemController::class, 'found'])->name('items.found');

// Authenticated User Pages
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => redirect()->route('home'))->name('dashboard');
    Route::get('/report-item', [ItemController::class, 'create'])->name('items.create');
    Route::post('/report-item', [ItemController::class, 'store'])->name('items.store');

    Route::post('/items/{item}/claim', [ClaimController::class, 'store'])->name('claims.store');
    Route::patch('/items/{item}/status', [ItemController::class, 'updateStatus'])->name('items.status');
    Route::get('/my-claims', [ClaimController::class, 'myClaims'])->name('claims.my');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Pages
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/claims', [AdminController::class, 'claims'])->name('claims');
    Route::patch('/claims/{claim}', [AdminController::class, 'updateClaim'])->name('claims.update');
    Route::delete('/items/{item}', [AdminController::class, 'destroyItem'])->name('items.destroy');
});

require __DIR__.'/auth.php';