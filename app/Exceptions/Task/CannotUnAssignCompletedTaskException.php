<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use Exception;

final class CannotUnAssignCompletedTaskException extends Exception
{
    public function __construct(int $taskId, int $userId)
    {
        parent::__construct("Cannot unassign a completed task, taskId: $taskId, userId: $userId");
    }
}
