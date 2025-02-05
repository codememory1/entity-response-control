<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface CollectorInterface
{
    public function collect(PropertyExecutionContextInterface $executionContext, object $object): array;
}