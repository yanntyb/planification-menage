<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CompleteAuthTaskRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'task_id' => 'required|integer|exists:tasks,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
