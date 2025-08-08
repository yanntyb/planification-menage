<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\Task\CannotValideAlreadyCompletedTaskException;
use App\Models\Pivot\TaskUser;

final readonly class CompleteUserTask
{
    public function handle(int $taskId, int $userId): bool
    {
        $pivot = TaskUser::query()
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->latest('id')
            ->first();

        if (! $pivot) {
            return false;
        }

        if ($pivot->completed_at) {
            throw new CannotValideAlreadyCompletedTaskException($taskId, $userId);
        }

        $pivot->update([
            'completed_at' => now(),
        ]);

        return true;
    }
}
