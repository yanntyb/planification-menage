<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskDeletedEvent;
use App\Models\Task;

final readonly class DeleteTask
{
    public function handle(int $id): void
    {
        Task::destroy($id);

        TaskDeletedEvent::dispatch($id);
    }
}
