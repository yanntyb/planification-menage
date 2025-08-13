<?php

declare(strict_types=1);

namespace App\Actions\Task;

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
                'points' => $point,
                'is_current' => true,
            ]);

        TaskPointUpdatedEvent::dispatch($taskPoint);

        return $taskPoint;

    }
}
