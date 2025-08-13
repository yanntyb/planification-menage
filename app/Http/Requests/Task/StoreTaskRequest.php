<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Http\Validation\Task\ValidateAvailableAfterRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $title
 * @property-read string $available_after
 *
 * @method array{'title': string, 'available_after': string|null} all()
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
            'available_after' => ['string'],
        ];
    }

    /**
     * @return callable[]
     */
    public function after(): array
    {
        return [
            new ValidateAvailableAfterRule($this->available_after),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
