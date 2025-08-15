<?php

declare(strict_types=1);

namespace App\Data;

use App\Exceptions\FrequencyInstantiationException;

final readonly class Frequency
{
    public function __construct(
        public int $years,
        public int $months,
        public int $days,
        public int $hours,
        public int $minutes,
        public int $secondes,
    ) {}

    public static function from(mixed $value): ?self
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof self) {
            $instance = $value;
        }

        if (is_string($value)) {
            $instance = self::fromString($value);
        }

        if (! ($instance ?? null)) {
            throw FrequencyInstantiationException::enableToConstructFromValue($value);
        }

        return $instance;

    }

    public static function fromString(string $value): ?self
    {
        preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $value, $matches);

        if (count($matches) !== 7) {
            return null;
        }

        [$_, $years, $months, $days, $hours, $minutes, $secondes] = $matches;

        return new self((int) $years, (int) $months, (int) $days, (int) $hours, (int) $minutes, (int) $secondes);
    }

    public function toString(): string
    {
        return sprintf('%04d-%02d-%02d %02d:%02d:%02d', $this->years, $this->months, $this->days, $this->hours, $this->minutes, $this->secondes);
    }
}
