<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CropString implements DecoratorInterface
{
    public function __construct(
        public readonly int $maxlength,
        public readonly string $end = '...'
    ) {
    }

    public function getHandler(): string
    {
        return CropStringHandler::class;
    }
}