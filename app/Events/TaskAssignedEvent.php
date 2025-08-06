<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

final class TaskAssignedEvent
{
    use Dispatchable;

    public function __construct(public Task $task, public User $user) {}
}
