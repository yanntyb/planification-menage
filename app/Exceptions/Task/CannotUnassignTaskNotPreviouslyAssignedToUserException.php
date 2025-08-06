<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use Exception;

final class CannotUnassignTaskNotPreviouslyAssignedToUserException extends Exception
{
    public function __construct(int $taskId, int $userId)
    {
        parent::__construct("Cannot unassign task not previously assigned, taskId: $taskId, userId: $userId");
    }
}
