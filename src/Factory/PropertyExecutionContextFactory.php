<?php

namespace Codememory\EntityResponseControl\Factory;

use Codememory\EntityResponseControl\Context\PropertyExecutionContext;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;

class PropertyExecutionContextFactory implements PropertyExecutionContextFactoryInterface
{
    public function create(PrototypeExecutionContextInterface $prototypeExecutionContext): PropertyExecutionContextInterface
    {
        return new PropertyExecutionContext($prototypeExecutionContext);
    }
}