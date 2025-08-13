<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\Task\TaskCreatedEvent;
use App\Models\Task;

final readonly class CreateTask
{
    /**
     * @param array{
     *     'title': string,
     *     'available_after': string|null
     * } $attributes
     */
    public function handle(array $attributes): Task
    {
        $task = Task::create($attributes);

        TaskCreatedEvent::dispatch($task);

        return $task;
    }
}
