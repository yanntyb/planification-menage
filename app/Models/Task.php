<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\Task\FrequencyCast;
use App\Data\Frequency;
use App\Models\Pivot\TaskUser;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property-read string $title
 * @property-read Frequency|null $frequency
 * @property-read TaskPoint|null $current_points
 */
final class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'frequency' => FrequencyCast::class,
    ];

    /**
     * @return Attribute<TaskPoint|null, never>
     */
    public function currentPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->points()->where('is_current', true)->latest()->first(),
        );
    }

    /**
     * @return BelongsToMany<User, $this, TaskUser>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(TaskUser::class)->withPivot('id', 'completed_at');
    }

    /**
     * @return HasMany<TaskPoint, $this>
     */
    public function points(): HasMany
    {
        return $this->hasMany(TaskPoint::class);
    }
}
