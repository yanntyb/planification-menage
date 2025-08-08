<?php

declare(strict_types=1);

namespace App\Events\User;

use Illuminate\Foundation\Events\Dispatchable;

final class UserDeletedEvent
{
    use Dispatchable;

    public function __construct(public int $id) {}
}
