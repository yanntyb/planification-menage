<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use App\Models\Task;
use App\Models\User;
use Exception;

final class TaskCannotBeCompletedException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function alreadyCompleted(Task $task, User $user): self
    {
        return new self("Cannot validate already completed task: $task->id for user: $user->id");
    }

    public static function taskNotAvailableYet(Task $task): self
    {
        return new self("Cannot validate task not available yet: $task->id");
    }
}
