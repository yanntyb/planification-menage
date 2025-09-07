<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class AssignableScope
{
    /**
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    public function __invoke(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave(
            'users',
            fn (Builder $query) => $query
                ->where('user_id', $user->id)
                ->where('completed_at', null)
        );
    }
}
