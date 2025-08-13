<?php

declare(strict_types=1);

namespace App\Http\Validation\Task;

use Illuminate\Contracts\Validation\Validator;

final class ValidateAvailableAfterRule
{
    public function __construct(public string $value) {}

    public function __invoke(Validator $validator): void
    {
        preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $this->value, $matches);

        if (count($matches) !== 7) {
            $validator->errors()->add('available_after', 'Invalid date format');
        }
    }
}
