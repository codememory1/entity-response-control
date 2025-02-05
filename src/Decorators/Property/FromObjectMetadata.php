<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class FromObjectMetadata implements PropertyDecoratorInterface
{
    public function __construct(
        public string $getterValueAsKey,
        public ?string $fromKey = null
    ) {
    }

    public function getHandler(): string
    {
        return FromMetadataHandler::class;
    }
}