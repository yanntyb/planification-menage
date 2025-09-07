<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\TaskPointFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class TaskPoint extends Model
{
    /** @use HasFactory<TaskPointFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    protected static function newFactory(): TaskPointFactory
    {
        return TaskPointFactory::new();
    }
}
