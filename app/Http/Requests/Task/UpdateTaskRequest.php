<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $points
 */
final class UpdateTaskRequest extends FormRequest
{
    /**
     * @phpstan-ignore-next-line
     */
    public function rules(): array
    {
        return [
            'points' => ['integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
