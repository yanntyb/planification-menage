<?php

declare(strict_types=1);

use App\Actions\User\Auth\CreateUserAccessToken;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;

describe('/api/auth/tasks', function () {
    it('redirect to login without token', function () {
        $this->get('/api/auth/tasks')->assertRedirectToRoute('login');
    });

    it('return a list of tasks', function () {
        $user = User::factory()->create();
        Task::factory()->count(3)->withPoints()->withUser($user)->create();

        assert($user->tasks->count() === 3);

        $token = app(CreateUserAccessToken::class)->handle($user);

        $this->get('/api/auth/tasks', ['Authorization' => "Bearer $token->plainTextToken"])
            ->assertOk()
            ->assertJson(TaskResource::collection($user->tasks)->resolve());
    });
});
