<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

describe('users endpoints', function () {
    test('index', function () {
        $user = User::factory()->create();

        $this->get('/api/users')
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('data')
                ->has('data', 1)
                ->has('data.0', fn (AssertableJson $json) => $json->where('id', $user->id)
                    ->where('email', $user->email)
                    ->etc()
                )
            );
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
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'tasks' => [],
                ],
            ]);
    });

    test('show user with task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        $this->get('/api/users/'.$user->id)
            ->assertOk()
            ->assertExactJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'tasks' => [
                        [
                            'id' => $task->id,
                            'title' => $task->title,
                            'points' => $task->current_points->points,
                        ],
                    ],
                ],
            ]);
    });
});
