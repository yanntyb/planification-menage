<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\User\UserDeletedEvent;
use App\Models\User;

final readonly class DeleteUser
{
    public function handle(User $user): bool
    {
        $deleted = $user->delete();

        if (! $deleted) {
            return false;
        }

        UserDeletedEvent::dispatch($user->id);

        return true;
    }
}
