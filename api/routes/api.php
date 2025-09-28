<?php

declare(strict_types = 1);

use App\Http\Middleware\ErrorResponseMiddleware;
use App\Http\Middleware\ForceJsonMiddleware;
use App\Http\Middleware\JsonResponseMiddleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::prefix('tasks')
    ->name('api')
    ->middleware([
        'throttle',
        HandleCors::class,
        ForceJsonMiddleware::class,
        JsonResponseMiddleware::class,
    ])
    ->group(function () {
        Route::get('/stats', [TaskController::class, 'statistics'])->name('statistics');
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{id}', [TaskController::class, 'find'])->name('find');
        Route::post('/', [TaskController::class, 'create'])->name('create');
        Route::patch('/{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{id}', [TaskController::class, 'delete'])->name('delete');
});
