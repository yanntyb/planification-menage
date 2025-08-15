<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;

describe('/api/auth/tasks/complete', function () {
    it('redirect to login without token', function () {
        $this->post('/api/auth/tasks/complete')->assertRedirectToRoute('login');
    });

    it('complete task', function () {
        $user = User::factory()->create();
        Task::factory()->withPoints()->withUser($user)->create();

        Sanctum::actingAs($user);

        $this->freezeTime(function (Carbon $now) use ($user) {
            $this->post('/api/auth/tasks/complete', ['task_id' => $user->tasks->first()->id])->assertOk();

            $this->assertDatabaseHas('task_user', [
                'user_id' => $user->id,
                'task_id' => $user->tasks->first()->id,
                'completed_at' => $now,
            ]);
        });
    });
});
