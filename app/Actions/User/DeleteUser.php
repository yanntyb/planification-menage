<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\User\UserDeletedEvent;
use App\Models\User;

final readonly class DeleteUser
{
    public function handle(int $id): bool
    {
        $deleted = User::destroy($id) === 1;

        if (! $deleted) {
            return false;
        }

        UserDeletedEvent::dispatch($id);

        return true;
    }
}
