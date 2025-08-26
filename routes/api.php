<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AssignAndCompleteAuthTaskController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthLoginController;
use App\Http\Controllers\Auth\Task\AssignAuthTaskController;
use App\Http\Controllers\Auth\Task\AuthTaskController;
use App\Http\Controllers\Auth\Task\CompleteAuthTaskController;
use App\Http\Controllers\Auth\Task\UnassignAuthTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\User\AssignUserTaskController;
use App\Http\Controllers\User\CompleteUserTaskController;
use App\Http\Controllers\User\UnassignUserTaskController;
use App\Http\Controllers\UserController;

Route::resource('tasks', TaskController::class);
Route::resource('users', UserController::class);

Route::post('users/{user}/tasks/{task}/complete', CompleteUserTaskController::class)->name('users.tasks.complete');
Route::post('users/{user}/tasks/{task}/assign', AssignUserTaskController::class)->name('users.tasks.assign');
Route::post('users/{user}/tasks/{task}/unassign', UnassignUserTaskController::class)->name('users.tasks.unassign');

Route::post('/auth/login', AuthLoginController::class)->name('login');

Route::middleware('auth:sanctum')
    ->prefix('/auth')
    ->group(function () {
        Route::get('/', AuthController::class)->name('auth.index');

        Route::prefix('tasks')
            ->group(function () {
                Route::get('/', AuthTaskController::class)->name('auth.tasks.index');
                Route::post('/{task}/assign', AssignAuthTaskController::class)->name('auth.tasks.assign');
                Route::post('/{task}/unassign', UnassignAuthTaskController::class)->name('auth.tasks.unassign');
                Route::post('/{task}/complete', CompleteAuthTaskController::class)->name('auth.tasks.complete');
                Route::post('/{task}/assign-complete', AssignAndCompleteAuthTaskController::class)->name('auth.tasks.assign-complete');
            });
    });
