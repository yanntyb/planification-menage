<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskPointUpdatedEvent;
use App\Models\TaskPoint;

final readonly class UpdateTaskPoint
{
    public function handle(int $taskId, int $point): TaskPoint
    {

        TaskPoint::where('task_id', $taskId)
            ->update([
                'is_current' => false,
            ]);

        $taskPoint = TaskPoint::create([
            'task_id' => $taskId,
            'points' => $point,
            'is_current' => true,
        ]);

        TaskPointUpdatedEvent::dispatch($taskPoint);

        return $taskPoint;

    }
}
