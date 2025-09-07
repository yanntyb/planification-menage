<?php

declare(strict_types=1);

namespace App\Models\Builder;

use App\Models\Scopes\AssignableScope;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Task>
 *
 * @method static assignableTo(User $user)
 */
final class TaskBuilder extends Builder
{
    /**
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    #[Scope]
    public function assignableTo(User $user): Builder
    {
        return app(AssignableScope::class)->__invoke($this, $user);
    }
}
