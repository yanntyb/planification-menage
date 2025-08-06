<?php

declare(strict_types=1);

namespace App\Events\Task;

use Illuminate\Foundation\Events\Dispatchable;

final class TaskDeletedEvent
{
    use Dispatchable;

    public function __construct(public int $id) {}
}
