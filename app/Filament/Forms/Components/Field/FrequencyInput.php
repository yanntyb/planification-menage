<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components\Field;

use App\Data\Frequency;
use Filament\Forms\Components\Field;

final class FrequencyInput extends Field
{
    protected string $view = 'filament.forms.components.frequency-picker';

    /**
     * @param  array{days: string, hours: string, minutes: string}  $state
     */
    public function mutateStateForValidation(mixed $state): string
    {
        $days = (int) $state['days'];
        $hours = (int) $state['hours'];
        $minutes = (int) $state['minutes'];

        return new Frequency(days: $days, hours: $hours, minutes: $minutes)->toString();
    }

    public function configure(): static
    {
        return $this->formatStateUsing(fn (?Frequency $state) => [
            'days' => $state->days ?? 0,
            'hours' => $state->hours ?? 0,
            'minutes' => $state->minutes ?? 0,
        ]);
    }
}
