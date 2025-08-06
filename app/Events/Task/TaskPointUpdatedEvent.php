<?php

declare(strict_types=1);

namespace App\Events\Task;

use App\Models\TaskPoint;
use Illuminate\Foundation\Events\Dispatchable;

final class TaskPointUpdatedEvent
{
    use Dispatchable;

    public function __construct(public TaskPoint $taskPoint) {}
}
