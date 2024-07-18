<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Plural implements DecoratorInterface
{
    public function __construct(
        public readonly string $word1,
        public readonly string $word2,
        public readonly string $word5,
        public readonly bool|array $callback = false
    ) {
    }

    public function getHandler(): string
    {
        return PluralHandler::class;
    }
}