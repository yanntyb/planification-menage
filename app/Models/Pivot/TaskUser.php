<?php

declare(strict_types=1);

namespace App\Models\Pivot;

use App\Models\TaskPoint;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read ?Carbon $completed_at
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
}
