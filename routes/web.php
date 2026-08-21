<?php

use App\Http\Controllers\Admin\EquipmentController as AdminEquipmentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\EnsureUserIsAdministrator;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified', EnsureUserIsActive::class])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

    Route::middleware(EnsureUserIsAdministrator::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');

        Route::resource('equipment', AdminEquipmentController::class);
    });
});

require __DIR__.'/settings.php';
