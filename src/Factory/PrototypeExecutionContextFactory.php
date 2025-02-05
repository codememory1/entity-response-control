<?php

namespace Codememory\EntityResponseControl\Factory;

use Codememory\EntityResponseControl\Context\PrototypeExecutionContext;
use Codememory\EntityResponseControl\Interfaces\PropertyWrapperFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeManagerInterface;
use Codememory\Reflection\Reflectors\ClassReflector;

readonly class PrototypeExecutionContextFactory implements PrototypeExecutionContextFactoryInterface
{
    public function __construct(
        private PropertyWrapperFactoryInterface $propertyWrapperFactory
    ) {
    }

    public function create(
        ResponsePrototypeManagerInterface $manager,
        ClassReflector $reflector,
        array|object $data,
        array $metadata = []
    ): PrototypeExecutionContextInterface {
        return new PrototypeExecutionContext($manager, $this->propertyWrapperFactory, $reflector, $data, $metadata);
    }
}