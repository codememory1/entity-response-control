<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTime implements DecoratorInterface
{
    public const STRING_FORMAT = 'string';
    public const FULL_FORMAT = 'full';
    public const TIMESTAMP_FORMAT = 'timestamp';
    public const FORMATS = [
        self::STRING_FORMAT,
        self::FULL_FORMAT,
        self::TIMESTAMP_FORMAT
    ];
    public const DEFAULT_FORMAT_OPTIONS = [
        self::STRING_FORMAT => [
            'format' => 'Y-m-d H:i:s' // type string
        ],
        self::FULL_FORMAT => [
            'date' => [
                'enabled' => true,
                'year' => [
                    'enabled' => true,
                    'format' => 'Y'
                ],
                'month' => [
                    'enabled' => true,
                    'format' => 'm'
                ],
                'week' => [
                    'enabled' => false,
                    'format' => 'w'
                ],
                'day' => [
                    'enabled' => true,
                    'format' => 'd'
                ],
                'show_leap_year' => false,
                'callback' => false // [class, method]
            ],
            'time' => [
                'enabled' => true,
                'hours' => [
                    'enabled' => true,
                    'format' => 'H'
                ],
                'minutes' => [
                    'enabled' => true,
                    'format' => 'i'
                ],
                'seconds' => [
                    'enabled' => true,
                    'format' => 's'
                ],
                'callback' => false // [class, method]
            ],
            'timestamp' => [
                'enabled' => true,
                'callback' => false // [class, method]
            ],
            'timezone' => [
                'enabled' => true,
                'callback' => false // [class, method]
            ],
            'callback' => false // [class, method]
        ],
        self::TIMESTAMP_FORMAT => []
    ];

    public function __construct(
        public readonly string $format = self::STRING_FORMAT,
        public readonly array $options = []
    ) {
    }

    public function getHandler(): string
    {
        return DateTimeHandler::class;
    }
}