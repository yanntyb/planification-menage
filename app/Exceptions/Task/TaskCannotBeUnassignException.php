<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use App\Models\Task;
use App\Models\User;
use Exception;

final class TaskCannotBeUnassignException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function assignationNotFound(Task $task, User $user): self
    {
        return new self("Cannot unassign task not previously assigned: $task->id for user: $user->id");
    }
}
