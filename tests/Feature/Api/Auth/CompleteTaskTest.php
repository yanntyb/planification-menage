<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;

describe('/api/auth/tasks/complete', function () {
    it('complete task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        Sanctum::actingAs($user);

        $this->freezeTime(function (Carbon $now) use ($user, $task) {
            $this->post("/api/auth/tasks/$task->id/complete")->assertOk();

            $this->assertDatabaseHas('task_user', [
                'user_id' => $user->id,
                'task_id' => $user->tasks->first()->id,
                'completed_at' => $now,
            ]);
        });
    });
});
