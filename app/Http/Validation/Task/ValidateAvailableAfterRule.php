<?php

declare(strict_types=1);

namespace App\Http\Validation\Task;

use App\Data\Frequency;
use App\Exceptions\FrequencyInstantiationException;
use Illuminate\Contracts\Validation\Validator;

final class ValidateAvailableAfterRule
{
    public function __construct(public string $value) {}

    public function __invoke(Validator $validator): void
    {
        if (! $this->value) {
            return;
        }

        try {
            Frequency::from($this->value);
        } catch (FrequencyInstantiationException $exception) {
            $validator->errors()->add('frequency', 'Invalid date format');
        }
    }
}
