<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Templating\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class Name
{
    private string $value;

    public function __construct(string $value)
    {
        if (Str::of($value)->empty()) {
            throw new DomainException;
        }

        $this->value = $value;
    }

    public function extension(): string
    {
        return \pathinfo($this->value, \PATHINFO_EXTENSION);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
