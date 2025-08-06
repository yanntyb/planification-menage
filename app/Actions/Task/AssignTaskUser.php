<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\CannotAssignTaskWithoutPointException;
use App\Models\Task;
use App\Models\User;

final readonly class AssignTaskUser
{
    public function handle(int $taskId, int $userId): bool
    {
        if (! (($task = Task::find($taskId)) && User::find($userId))) {
            return false;
        }

        if (! $task->current_points) {
            throw new CannotAssignTaskWithoutPointException($taskId);
        }

        $task->users()->attach($userId);

        TaskAssignedEvent::dispatch($task, User::find($userId));

        return true;
    }
}
