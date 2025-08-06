<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\User\UserCreatedEvent;
use App\Models\User;
use Hash;

final readonly class CreateUser
{
    public function handle(string $name, string $email, string $password): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        UserCreatedEvent::dispatch($user);

        return $user;
    }
}
