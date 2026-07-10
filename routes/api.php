<?php

use Modules\ModuleManager\App\Http\Controllers\Api\V1\Admin\ModuleController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

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
    });
