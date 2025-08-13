<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;

describe('users/{user}/tasks/{task}/unassign', function () {
    it('can unassign task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        $this->post("/api/users/{$task->id}/tasks/{$user->id}/unassign")
            ->assertOk();

        $this->assertDatabaseMissing('task_user', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    });
});
