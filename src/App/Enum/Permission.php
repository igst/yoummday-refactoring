<?php

declare(strict_types=1);

namespace App\Enum;

enum Permission: string
{
    case READ  = 'read';
    case WRITE = 'write';

    public static function fromString(string $value): self
    {
        return match ($value) {
            self::READ->value  => self::READ,
            self::WRITE->value => self::WRITE,
            default            => throw new \InvalidArgumentException(sprintf('Unknown permission: %s', $value))
        };
    }
}
