<?php

declare(strict_types=1);

namespace App\Models\Pivot;

use App\Models\Task;
use App\Models\TaskPoint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read Carbon|null $completed_at
 * @property-read User $user
 * @property-read Task $task
 */
final class TaskUser extends Pivot
{
    public $incrementing = true;

    public $timestamps = false;

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<TaskPoint, $this>
     */
    public function point(): BelongsTo
    {
        return $this->belongsTo(TaskPoint::class, 'task_point_id', 'id');
    }

    /**
     * @return BelongsTo<Task, $this>
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
