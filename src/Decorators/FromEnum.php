<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class FromEnum implements DecoratorInterface
{
    public const KEY_LABEL_FORMAT = 'key_label';
    public const ONLY_KEY_FORMAT = 'only_key';
    public const ONLY_LABEL_FORMAT = 'only_label';
    public const FORMATS = [
        self::KEY_LABEL_FORMAT,
        self::ONLY_KEY_FORMAT,
        self::ONLY_LABEL_FORMAT
    ];

    public function __construct(
        public readonly string $format = self::KEY_LABEL_FORMAT
    ) {
    }

    public function getHandler(): string
    {
        return FromEnumHandler::class;
    }
}
