<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Http\Validation\Task\ValidateAvailableAfterRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $title
 * @property-read string $frequency
 *
 * @method array{'title': string, 'frequency': string|null} all()
 * @method array{'title': string, 'frequency': string|null} validated()
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
            'frequency' => ['string'],
        ];
    }

    /**
     * @return callable[]
     */
    public function after(): array
    {
        return [
            new ValidateAvailableAfterRule($this->frequency ?? ''),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
