<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\Task\TaskCannotBeCompletedException;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use App\Models\User;
use App\Services\Task\IsTaskAvailable;

final readonly class CompleteUserTask
{
    public function __construct(public IsTaskAvailable $isTaskAvailable) {}

    public function handle(Task $task, User $user): bool
    {
        if (! $this->isTaskAvailable->check($task)) {
            throw TaskCannotBeCompletedException::taskNotAvailableYet($task);
        }

        $pivot = TaskUser::query()
            ->where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        if (! $pivot) {
            return false;
        }

        if ($pivot->completed_at) {
            throw TaskCannotBeCompletedException::alreadyCompleted($task, $user);
        }

        $task->users()->updateExistingPivot($user->id, [
            'completed_at' => now(),
        ]);

        return true;
    }
}
