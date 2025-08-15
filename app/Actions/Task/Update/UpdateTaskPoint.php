<?php

declare(strict_types=1);

namespace App\Actions\Task\Update;

use App\Events\Task\TaskPointUpdatedEvent;
use App\Models\Task;
use App\Models\TaskPoint;

final readonly class UpdateTaskPoint
{
    public function handle(Task $task, int $point): TaskPoint
    {

        $task->points()
            ->where('is_current', true)
            ->update([
                'is_current' => false,
            ]);

        $taskPoint = $task->points()
            ->create([
                'value' => $point,
                'is_current' => true,
            ]);

        TaskPointUpdatedEvent::dispatch($taskPoint);

        $task->refresh();

        return $taskPoint;

    }
}
