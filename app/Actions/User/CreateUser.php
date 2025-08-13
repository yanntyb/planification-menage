<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\User\UserCreatedEvent;
use App\Models\User;
use Hash;

final readonly class CreateUser
{
    /**
     * @param array{
     *     'name': string, 'email': string, 'password': string
     * } $attributes
     */
    public function handle(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);

        $user = User::create($attributes);

        UserCreatedEvent::dispatch($user);

        return $user;
    }
}
