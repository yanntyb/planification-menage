<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Pivot\TaskUser;
use App\Models\Task;

final class IsTaskAvailable
{
    public function check(Task $task): bool
    {
        if (! $task->frequency) {
            return true;
        }

        $lastCompleted = TaskUser::query()
            ->whereNotNull('completed_at')
            ->where('task_id', $task->id)
            ->latest('completed_at')
            ->first()
            ?->completed_at;

        if (! $lastCompleted) {
            return true;
        }

        $nextAvailableDate = $lastCompleted
            ->addYears($task->frequency->years)
            ->addMonths($task->frequency->months)
            ->addDays($task->frequency->days)
            ->addHours($task->frequency->hours)
            ->addMinutes($task->frequency->minutes)
            ->addSeconds($task->frequency->secondes);

        return now()->isAfter($nextAvailableDate);

    }
}
