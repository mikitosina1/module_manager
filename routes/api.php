<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleManager\App\Http\Controllers\Api\V1\Admin\ModuleController;

Route::prefix('v1/admin/modules')
    ->middleware(['auth:sanctum', 'is_admin'])
    ->name('api.v1.admin.modules.')
    ->group(function () {

        Route::get('/', [ModuleController::class, 'index'])
            ->name('index');

        Route::post('/{module}/enable', [ModuleController::class, 'enable'])
            ->name('enable');

        Route::post('/{module}/disable', [ModuleController::class, 'disable'])
            ->name('disable');

        Route::delete('/{module}', [ModuleController::class, 'destroy'])
            ->name('destroy');

        Route::prefix('{module}/settings')
            ->name('settings.')
            ->group(function () {

                Route::get('/', [ModuleController::class, 'getSettings'])
                    ->name('index');

                Route::put('/access', [ModuleController::class, 'setAccess'])
                    ->name('access');

            });
    });