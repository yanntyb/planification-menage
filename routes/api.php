<?php

declare(strict_types=1);

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
