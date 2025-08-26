<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Pivot\TaskUser;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read TaskUser|null $pivot
 *
 * @phpstan-type TaskResourceArray array{
 *     'id': int,
 *     'title': string,
 *     'points': int,
 *     'last_completed_at': ?string
 * }
 *
 * @method static AnonymousResourceCollection<TaskResource> collection($resource)
 *
 * @mixin Task
 */
final class TaskResource extends JsonResource
{
    /**
     * @return TaskResourceArray
     */
    public function toArray(Request $request): array
    {
        /** @var int $points */
        $points = $this->whenPivotLoaded(TaskUser::class, fn () => $this->pivot->point->value ?? 0, $this->current_points->value ?? 0);

        $lastCompletedAssignation = TaskUser::query()
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->first();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'points' => $points,
            'last_completed_at' => $lastCompletedAssignation?->completed_at,
        ];
    }
}
