<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AliasInResponse implements DecoratorInterface
{
    public function __construct(
        public readonly string $alias
    ) {
    }

    public function getHandler(): string
    {
        return AliasInResponseHandler::class;
    }
}