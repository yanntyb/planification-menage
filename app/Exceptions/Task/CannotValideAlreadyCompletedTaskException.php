<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use Exception;

final class CannotValideAlreadyCompletedTaskException extends Exception
{
    public function __construct(int $taskId, int $userId)
    {
        parent::__construct("Cannot validate already completed task: $taskId for user: $userId");
    }
}
