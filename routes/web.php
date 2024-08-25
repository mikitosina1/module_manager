<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleManager\App\Http\Controllers\ModuleManagerController;
use Nwidart\Modules\Facades\Module;

Route::prefix('module')->group(function () {
	Route::post('/enable', [ModuleManagerController::class, 'enable'])->name('module.enable');
	Route::post('/disable', [ModuleManagerController::class, 'disable'])->name('module.disable');
	Route::post('/delete', [ModuleManagerController::class, 'delete'])->name('module.delete');
});

Route::get('/dashboard', function () {
	$modules = Module::all();
	return view('dashboard', compact('modules'));
})->middleware(['auth', 'verified'])->name('dashboard');
