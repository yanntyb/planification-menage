<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

final class AuthController extends Controller
{
    public function __invoke(Request $request): UserResource
    {
        return UserResource::make($request->user());
    }
}
