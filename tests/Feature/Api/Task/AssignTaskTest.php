<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;

describe('users/{user}/tasks/{task}/assign', function () {
    it('can unassign task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->create();

        $this->post("/api/users/{$task->id}/tasks/{$user->id}/assign")
            ->assertOk();

        $this->assertDatabaseHas('task_user', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    });
});
