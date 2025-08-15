<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $points
 *
 * @method array{'title': string|null, 'frequency': string|null, 'points': int|null} validated()
 * @method array{'title': string|null, 'frequency': string|null, 'points': int|null} all()
 */
final class UpdateTaskRequest extends FormRequest
{
    /**
     * @phpstan-ignore-next-line
     */
    public function rules(): array
    {
        return [
            'title' => ['string'],
            'frequency' => ['string'],
            'points' => ['integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
