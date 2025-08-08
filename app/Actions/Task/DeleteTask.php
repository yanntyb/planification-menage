<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskDeletedEvent;
use App\Models\Task;

final readonly class DeleteTask
{
    public function handle(int $id): bool
    {
        $deleted = Task::destroy($id) === 1;

        if (! $deleted) {
            return false;
        }

        TaskDeletedEvent::dispatch($id);

        return true;
    }
}
