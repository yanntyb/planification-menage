<?php

declare(strict_types=1);

namespace App\Filament\Table\Columns;

use App\Models\Task;
use Filament\Tables\Columns\TextColumn;

final class CurrentPointColumn extends TextColumn
{
    public function configure(): static
    {
        return $this->state(fn (Task $record) => $record->current_points?->value);
    }
}
