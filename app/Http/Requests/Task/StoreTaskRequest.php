<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $title
 */
final class StoreTaskRequest extends FormRequest
{
    /**
     * @phpstan-ignore-next-line
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
