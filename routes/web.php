<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/api/location', [DriverController::class, 'getLocation']); // Public API for map

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Operational Routes
Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
Route::get('/finance/export', [FinanceController::class, 'exportPdf'])->name('finance.export');

Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition');
Route::get('/nutrition/export', [NutritionController::class, 'exportPdf'])->name('nutrition.export');

// Protected Operational Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/driver', [DriverController::class, 'index'])->name('driver');
    Route::post('/api/location', [DriverController::class, 'updateLocation']);

    // Admin Panel
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Users CRUD
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        
        // SPPG CRUD
        Route::get('/sppg', [AdminController::class, 'sppg'])->name('admin.sppg');
        Route::post('/sppg', [AdminController::class, 'storeSppg'])->name('admin.sppg.store');
        Route::put('/sppg/{id}', [AdminController::class, 'updateSppg'])->name('admin.sppg.update');
        Route::delete('/sppg/{id}', [AdminController::class, 'destroySppg'])->name('admin.sppg.destroy');
        
        // Menu CRUD
        Route::get('/menus', [AdminController::class, 'menus'])->name('admin.menus');
        Route::post('/menus', [AdminController::class, 'storeMenu'])->name('admin.menus.store');
        Route::put('/menus/{id}', [AdminController::class, 'updateMenu'])->name('admin.menus.update');
        Route::delete('/menus/{id}', [AdminController::class, 'destroyMenu'])->name('admin.menus.destroy');

        // Finance Management (Admin Only)
        Route::get('/finance', [AdminController::class, 'finance'])->name('admin.finance');
        Route::post('/finance/upload', [FinanceController::class, 'uploadInvoice'])->name('admin.finance.upload');
        Route::post('/finance/record', [AdminController::class, 'storeFinance'])->name('admin.finance.store');
        Route::delete('/finance/{id}', [AdminController::class, 'destroyFinance'])->name('admin.finance.destroy');
    });
});
