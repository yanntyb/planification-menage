<?php

declare(strict_types=1);

use App\Actions\User\CreateUserAccessToken;
use App\Http\Resources\UserResource;
use App\Models\User;

describe('/api/auth', function () {
    it('redirect to login without token', function () {
        $this->get('/api/auth')->assertRedirectToRoute('login');
    });

    it('success with token', function () {
        $user = User::factory()->create();

        $token = app(CreateUserAccessToken::class)->handle($user);

        $this->get('/api/auth', ['Authorization' => "Bearer $token->plainTextToken"])->assertOk();
    });

    it('return a resource resource', function () {
        $user = User::factory()->create();

        $token = app(CreateUserAccessToken::class)->handle($user);

        $this->get('/api/auth', ['Authorization' => "Bearer $token->plainTextToken"])
            ->assertJson(UserResource::make($user)->resolve());
    });
});
