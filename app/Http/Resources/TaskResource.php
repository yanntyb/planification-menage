<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @phpstan-type TaskResourceArray array{
 *     'id': int,
 *     'title': string,
 *     'points': int,
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'points' => $this->current_points->points ?? 0,
        ];
    }
}
