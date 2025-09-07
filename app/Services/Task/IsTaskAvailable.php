<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;

final class IsTaskAvailable
{
    public function __construct(public NextAvailability $nextAvailability) {}

    public function check(Task $task): bool
    {
        if (! $task->frequency) {
            return true;
        }

        $nextAvailability = $this->nextAvailability->get($task);

        $diffInSeconds = now()->diffInSeconds($nextAvailability);

        return $diffInSeconds < 1;
    }
}
