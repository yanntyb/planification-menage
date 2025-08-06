<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskUnassignedEvent;
use App\Exceptions\Task\CannotUnAssignCompletedTaskException;
use App\Exceptions\Task\CannotUnassignTaskNotPreviouslyAssignedToUserException;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use App\Models\User;

final readonly class UnassignTaskUser
{
    public function handle(int $taskId, int $userId): bool
    {
        $pivot = TaskUser::query()
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->latest('id')
            ->first();

        if (! $pivot) {
            throw new CannotUnassignTaskNotPreviouslyAssignedToUserException($taskId, $userId);
        }

        if ($pivot->completed_at) {
            throw new CannotUnAssignCompletedTaskException($taskId, $userId);
        }

        if (! $pivot->delete()) {
            return false;
        }

        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        TaskUnassignedEvent::dispatch($task, $user);

        return true;
    }
}
