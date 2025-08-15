<?php

declare(strict_types=1);

use App\Actions\Task\Update\UpdateTaskPoint;
use App\Http\Resources\UserResource;
use App\Models\Task;
use App\Models\User;

describe('users endpoints', function () {
    test('index', function () {
        $user = User::factory()->create();

        $this->get('/api/users')
            ->assertOk()
            ->assertJson([UserResource::make($user)->resolve()]);
    });

    test('store', function () {
        $email = fake()->email();
        $this->post('/api/users', [
            'name' => '<NAME>',
            'email' => $email,
            'password' => '<PASSWORD>',
            'password_confirmation' => '<PASSWORD>',
        ])->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => '<NAME>',
            'email' => $email,
        ]);
    });

    test('delete', function () {
        $user = User::factory()->create();

        $this->delete('/api/users/'.$user->id)->assertNoContent();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    });

    test('show user without task', function () {
        $user = User::factory()->create();

        $this->get('/api/users/'.$user->id)
            ->assertOk()
            ->assertExactJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tasks' => [],
            ]);
    });

    test('show user with task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        $userTask = $user->tasks()->withPivot(['completed_at'])->firstWhere('task_id', $task->id);

        $this->get('/api/users/'.$user->id)
            ->assertOk()
            ->assertExactJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tasks' => [
                    [
                        'id' => $task->id,
                        'title' => $task->title,
                        'points' => $userTask->pivot->point->value,
                    ],
                ],
            ]);
    });

    test('show user with task point being the ones at the association moment', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        $userTask = $user->tasks()->withPivot(['completed_at'])->firstWhere('task_id', $task->id);

        $basePoint = $userTask->pivot->point->value;

        app(UpdateTaskPoint::class)->handle($task, $basePoint + 1);

        expect($task->current_points->value)->toBe($basePoint + 1);

        $this->get('/api/users/'.$user->id)
            ->assertOk()
            ->assertExactJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tasks' => [
                    [
                        'id' => $task->id,
                        'title' => $task->title,
                        'points' => $basePoint,
                    ],
                ],
            ]);
    });
});
