<?php

declare(strict_types=1);

use App\Actions\User\DeleteUser;
use App\Events\User\UserDeletedEvent;
use App\Models\User;

describe(DeleteUser::class, function () {
    it('can delete user', function () {
        $user = User::factory()->create();

        app(DeleteUser::class)->handle($user);

        expect($user->fresh())->toBeNull();
    });

    it('fire event', function () {
        Event::fake();

        $user = User::factory()->create();

        app(DeleteUser::class)->handle($user);

        Event::assertDispatched(fn (UserDeletedEvent $event) => $event->id === $user->id);
    });
});
