<?php

declare(strict_types=1);

namespace App\Events\Task;

use App\Models\Task;
use Illuminate\Foundation\Events\Dispatchable;

final class TaskFrequencyUpdated
{
    use Dispatchable;

    public function __construct(public Task $task) {}
}
