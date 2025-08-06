<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use Exception;

final class CannotAssignTaskWithoutPointException extends Exception
{
    public function __construct(int $taskId)
    {
        parent::__construct("Cannot assign user to task without points task: $taskId");
    }
}
