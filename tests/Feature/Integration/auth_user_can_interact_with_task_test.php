<?php

use App\Models\Task;
use App\Models\User;

test('auth user can assign a task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->withPoints()->create();

    $token = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password'
    ])->json('token');

    $this
        ->withHeader('Authorization', 'Bearer ' . $token)
        ->post(route('auth.tasks.assign',[
            'task' => $task->id,
        ]))
        ->assertOk();

    $this->assertDatabaseHas('task_user', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

test('auth user can unassign a task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->withPoints()->withUser($user)->create();

    $this->assertDatabaseHas('task_user', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);

    $token = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password'
    ])->json('token');

    $this
        ->withHeader('Authorization', 'Bearer ' . $token)
        ->post(route('auth.tasks.unassign',[
            'task' => $task->id,
        ]))
        ->assertOk();

    $this->assertDatabaseMissing('task_user', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

test('auth user can complete an assigned task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->withPoints()->withUser($user)->create();

    $this->assertDatabaseHas('task_user', [
        'user_id' => $user->id,
        'task_id' => $task->id,
        'completed_at' => null
    ]);

    $token = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password'
    ])->json('token');

    $this->freezeTime(function (Carbon\Carbon $now)  use ($token, $task, $user) {
        $this
            ->withHeader('Authorization', 'Bearer ' . $token)
            ->post(route('auth.tasks.complete',[
                'task' => $task->id,
            ]))
            ->assertOk();

        $this->assertDatabaseHas('task_user', [
            'user_id' => $user->id,
            'task_id' => $task->id,
            'completed_at' => $now
        ]);
    });
});

test('auth user can assign and directly complete a tak ', function () {
    $user = User::factory()->create();
    $task = Task::factory()->withPoints()->create();

    $this->assertDatabaseMissing('task_user', [
        'user_id' => $user->id,
        'task_id' => $task->id
    ]);

    $token = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password'
    ])->json('token');

    $this->freezeTime(function (Carbon\Carbon $now)  use ($token, $task, $user) {
        $this
            ->withHeader('Authorization', 'Bearer ' . $token)
            ->post(route('auth.tasks.assign-complete', ['task' => $task->id]))
            ->assertOk();

        $this->assertDatabaseHas('task_user', [
            'user_id' => $user->id,
            'task_id' => $task->id,
            'completed_at' => $now
        ]);
    });

});
