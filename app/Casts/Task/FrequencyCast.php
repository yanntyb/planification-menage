<?php

declare(strict_types=1);

namespace App\Casts\Task;

use App\Data\Frequency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<Frequency|null, string|null>
 */
final class FrequencyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Frequency
    {
        return Frequency::from($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return Frequency::from($value)?->toString();
    }
}
