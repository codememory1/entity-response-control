<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface PropertyExecutionContextFactoryInterface
{
    public function create(PrototypeExecutionContextInterface $prototypeExecutionContext): PropertyExecutionContextInterface;
}