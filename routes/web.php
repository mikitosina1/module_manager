<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleManager\App\Http\Controllers\ModuleManagerController;

Route::middleware(['auth', 'verified', 'is_admin'])
    ->prefix('admin/module')
    ->name('module.')
    ->group(function () {
        Route::get('/', [ModuleManagerController::class, 'index'])->name('index');
        Route::post('/enable', [ModuleManagerController::class, 'enable'])->name('enable');
        Route::post('/disable', [ModuleManagerController::class, 'disable'])->name('disable');
        Route::post('/delete', [ModuleManagerController::class, 'delete'])->name('delete');
    });
