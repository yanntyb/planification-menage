<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class FrequencyInstantiationException extends Exception
{
    /**
     * @var mixed[]
     */
    private array $context;

    /**
     * @param  mixed[]  $context
     */
    public function __construct(string $message, array $context = [])
    {
        parent::__construct($message);

        $this->context = $context;
    }

    public static function enableToConstructFromValue(mixed $value): self
    {
        return new self('Cannot construct from value', ['value' => $value]);
    }

    /**
     * @return mixed[]
     */
    public function context(): array
    {
        return $this->context;
    }
}
