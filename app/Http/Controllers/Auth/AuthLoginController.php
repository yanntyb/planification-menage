<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\Auth\CreateUserAccessToken;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class AuthLoginController
{
    public function __construct(public CreateUserAccessToken $createAuthToken) {}

    public function __invoke(LoginRequest $request): TokenResource
    {
        $user = User::firstWhere('email', $request->email);

        if (! ($user && Hash::check($request->password, $user->password))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new TokenResource($this->createAuthToken->handle($user));
    }
}
