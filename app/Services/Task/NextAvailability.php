<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Pivot\TaskUser;
use App\Models\Task;
use Carbon\CarbonImmutable;

final class NextAvailability
{
    public function get(Task $task): CarbonImmutable
    {
        if (! $task->frequency) {
            return now()->toImmutable();
        }

        $lastCompleted = TaskUser::query()
            ->whereNotNull('completed_at')
            ->where('task_id', $task->id)
            ->latest('completed_at')
            ->first()
            ?->completed_at;

        if (! $lastCompleted) {
            return now()->startOfSecond()->toImmutable();
        }

        return $lastCompleted
            ->addYears($task->frequency->years)
            ->addMonths($task->frequency->months)
            ->addDays($task->frequency->days)
            ->addHours($task->frequency->hours)
            ->addMinutes($task->frequency->minutes)
            ->addSeconds($task->frequency->secondes)
            ->startOfSecond()
            ->toImmutable();

    }
}
