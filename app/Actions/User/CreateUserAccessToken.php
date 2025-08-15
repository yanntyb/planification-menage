<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

final class CreateUserAccessToken
{
    public function handle(User $user): NewAccessToken
    {
        return $user->createToken('auth_token');
    }
}
