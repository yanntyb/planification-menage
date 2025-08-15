<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Actions\Task\Update\UpdateTaskFrequency;
use App\Actions\Task\Update\UpdateTaskPoint;
use App\Data\Frequency;
use App\Models\Task;

final class UpdateTask
{
    public function __construct(
        public UpdateTaskPoint $updateTaskPoint,
        public UpdateTaskFrequency $updateTaskFrequency,
    ) {}

    /**
     * @param array{
     *     'points': ?int,
     *     'frequency': string|Frequency|null,
     *     'title': ?string
     * } $attributes
     */
    public function handle(Task $task, array $attributes): Task
    {
        if ($points = $attributes['points'] ?? null) {
            $this->updateTaskPoint->handle($task, $points);

            unset($attributes['points']);
        }

        if ($frequency = $attributes['frequency'] ?? null) {
            $this->updateTaskFrequency->handle($task, $frequency);
            unset($attributes['frequency']);
        }

        $task->update($attributes);

        return $task;

    }
}
