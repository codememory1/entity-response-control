<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\ClassReflector;

interface PrototypeExecutionContextFactoryInterface
{
    public function create(
        ResponsePrototypeManagerInterface $manager,
        ClassReflector $reflector,
        array|object $data,
        array $metadata = []
    ): PrototypeExecutionContextInterface;
}