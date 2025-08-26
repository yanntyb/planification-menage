<?php

declare(strict_types=1);

namespace App\Actions\Task\Update;

use App\Data\Frequency;
use App\Events\Task\TaskUpdated;
use App\Models\Task;

final class UpdateTaskFrequency
{
    public function __construct() {}

    public function handle(Task $task, string|Frequency $frequency): Task
    {
        $task->update(['frequency' => $frequency]);

        TaskUpdated::dispatch($task);

        return $task;
    }
}
