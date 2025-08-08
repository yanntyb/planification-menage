<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @phpstan-import-type TaskResourceArray from TaskResource
 *
 * @phpstan-type UserResourceArray array{
 *      'id': int,
 *      'name': string,
 *      'email': string,
 *      'tasks': AnonymousResourceCollection<TaskResource>
 *  }
 *
 * @method static AnonymousResourceCollection<UserResource> collection($resource)
 *
 * @mixin User
 */
final class UserResource extends JsonResource
{
    /**
     * @return UserResourceArray
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
