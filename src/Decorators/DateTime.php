<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTime implements DecoratorInterface
{
    public function __construct(
        public readonly string $format = 'Y-m-d H:i:s',
        public readonly bool $full = false
    ) {
    }

    public function getHandler(): string
    {
        return DateTimeHandler::class;
    }
}