<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\ObjectDisassemblers\ObjectDisassembler;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CallbackResponseConstraint implements ConstraintInterface
{
    public function __construct(
        public readonly string $namespaceResponseData,
        public readonly string $disassembler = ObjectDisassembler::class,
        public readonly array $ignoreProperties = [],
        public readonly array $onlyProperties = []
    ) {
    }

    public function getHandler(): string
    {
        return CallbackResponseConstraintHandler::class;
    }
}