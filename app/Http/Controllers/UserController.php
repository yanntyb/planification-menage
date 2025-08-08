<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\CreateUser;
use App\Actions\User\DeleteUser;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class UserController extends Controller
{
    /**
     * @return AnonymousResourceCollection<UserResource>
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $user = app(CreateUser::class)->handle($request->name, $request->email, $request->password);

        return new UserResource($user);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load('tasks'));
    }

    public function destroy(User $user): Response
    {
        $deleted = app(DeleteUser::class)->handle($user->id);

        if (! $deleted) {
            return response(null, 500);
        }

        return response()->noContent();
    }
}
