<?php

declare(strict_types=1);

use App\Actions\User\CreateUser;
use App\Events\User\UserCreatedEvent;

describe(CreateUser::class, function () {
    it('can create user', function () {
        $email = fake()->email();
        $user = app(CreateUser::class)->handle([
            'name' => 'name',
            'email' => $email,
            'password' => 'password',
        ]);

        expect($user)->exists()->toBeTrue()
            ->email->toBe($email)
            ->name->toBe('name')
            ->and(Hash::check('password', $user->password))->toBeTrue();

    });

    it('fire event', function () {
        Event::fake();

        $user = app(CreateUser::class)->handle([
            'name' => 'name',
            'email' => fake()->email(),
            'password' => 'password',
        ]);

        Event::assertDispatched(fn (UserCreatedEvent $event) => $event->user->id === $user->id);
    });
});
