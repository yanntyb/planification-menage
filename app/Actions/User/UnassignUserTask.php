<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\Task\TaskUnassignedEvent;
use App\Exceptions\Task\TaskCannotBeUnassignException;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use App\Models\User;

final readonly class UnassignUserTask
{
    public function handle(Task $task, User $user): bool
    {
        $pivot = TaskUser::query()
            ->where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->latest('id')
            ->first();

        if (! $pivot) {
            throw TaskCannotBeUnassignException::assignationNotFound($task, $user);
        }

        if (! $pivot->delete()) {
            return false;
        }

        TaskUnassignedEvent::dispatch($task, $user);

        return true;
    }
}
