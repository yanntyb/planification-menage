<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskDeletedEvent;
use App\Models\Task;

final readonly class DeleteTask
{
    public function handle(Task $task): bool
    {
        $deleted = $task->delete();

        if (! $deleted) {
            return false;
        }

        TaskDeletedEvent::dispatch($task->id);

        return true;
    }
}
