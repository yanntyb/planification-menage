<?php

declare(strict_types=1);

namespace App\Exceptions\Task;

use App\Models\Task;
use Exception;

final class TaskCannotBeAssignedException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function taskHasNoPoints(Task $task): self
    {
        return new self("Cannot assign task with no points: $task->id");
    }
}
