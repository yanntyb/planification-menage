<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskCreatedEvent;
use App\Models\Task;

final readonly class CreateTask
{
    public function handle(string $title): Task
    {
        $task = Task::create([
            'title' => $title,
        ]);

        TaskCreatedEvent::dispatch($task);

        return $task;
    }
}
