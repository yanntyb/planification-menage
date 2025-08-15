<?php

declare(strict_types=1);

use App\Models\User;

describe('/api/auth/login', function () {
    it('give a token', function () {
        $user = User::factory()->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk();

        expect($response->json('token'))->not()->toBeNull();
    });
});
