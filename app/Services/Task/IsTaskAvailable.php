<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Pivot\TaskUser;
use App\Models\Task;

final class IsTaskAvailable
{
    public function check(Task $task): bool
    {
        if (! $task->available_after) {
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

        preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $task->available_after, $matches);
        [$_, $years, $months, $days, $hours, $minutes, $secondes] = $matches;

        $toInt = static fn (string|int &$value) => $value = (int) $value;

        $nextAvailableDate = $lastCompleted
            ->addYears($toInt($years))
            ->addMonths($toInt($months))
            ->addDays($toInt($days))
            ->addHours($toInt($hours))
            ->addMinutes($toInt($minutes))
            ->addSeconds($toInt($secondes));

        return now()->isAfter($nextAvailableDate);

    }
}
