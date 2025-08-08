<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $user_id
 */
final class AssignUserTaskRequest extends FormRequest
{
    /**
     * @phpstan-ignore-next-line
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
