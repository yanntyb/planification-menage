<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\TaskCannotBeAssignedException;
use App\Models\Task;
use App\Models\User;

final readonly class AssignUserTask
{
    public function handle(Task $task, User $user): bool
    {
        if (! $task->current_points) {
            throw TaskCannotBeAssignedException::taskHasNoPoints($task);
        }

        $task->users()->attach($user->id, [
            'task_point_id' => $task->current_points->id,
        ]);

        TaskAssignedEvent::dispatch($task, $user);

        return true;
    }
}
