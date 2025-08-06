<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class TaskPoint extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_current' => 'boolean',
    ];
}
