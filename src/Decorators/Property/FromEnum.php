<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FromEnum implements PropertyDecoratorInterface
{
    public const string KEY_LABEL_FORMAT = 'key_label';
    public const string ONLY_KEY_FORMAT = 'only_key';
    public const string ONLY_LABEL_FORMAT = 'only_label';
    public const array FORMATS = [
        self::KEY_LABEL_FORMAT,
        self::ONLY_KEY_FORMAT,
        self::ONLY_LABEL_FORMAT
    ];

    public function __construct(
        public readonly string $format = self::ONLY_KEY_FORMAT,
        public readonly bool $multiple = false
    ) {
    }

    public function getHandler(): string
    {
        return FromEnumHandler::class;
    }
}
