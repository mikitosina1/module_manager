<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleManager\App\Http\Controllers\ModuleManagerController;

Route::prefix('module')->group(function () {
	Route::post('/enable', [ModuleManagerController::class, 'enable'])->name('module.enable');
	Route::post('/disable', [ModuleManagerController::class, 'disable'])->name('module.disable');
});
