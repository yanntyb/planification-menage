<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\CannotAssignTaskWithoutPointException;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use App\Models\User;

final readonly class AssignUserTask
{
    public function handle(int $taskId, int $userId): bool
    {
        if (! (($task = Task::find($taskId)) && User::find($userId))) {
            return false;
        }

        if (! $task->current_points) {
            throw new CannotAssignTaskWithoutPointException($taskId);
        }

        TaskUser::create([
            'task_id' => $taskId,
            'user_id' => $userId,
            'task_point_id' => $task->current_points->id,
        ]);

        TaskAssignedEvent::dispatch($task, User::find($userId));

        return true;
    }
}
