<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Prefix implements DecoratorInterface
{
    public function __construct(
        public readonly ?string $prototypeObject = null,
        public readonly ?string $response = null
    ) {
    }

    public function getHandler(): string
    {
        return PrefixHandler::class;
    }
}