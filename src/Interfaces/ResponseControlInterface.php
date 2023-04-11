<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\Registers\ConstraintHandlerRegister;
use Codememory\EntityResponseControl\Registers\ConstraintTypeHandlerRegister;
use Codememory\Reflection\ReflectorManager;

interface ResponseControlInterface
{
    /**
     * @param array<int, object>|object $data
     */
    public function setData(array|object $data): self;

    public function getReflectorManager(): ReflectorManager;

    public function getConstraintTypeHandlerRegister(): ConstraintTypeHandlerRegister;

    public function getConstraintHandlerRegister(): ConstraintHandlerRegister;

    public function getObjectDisassembler(): ObjectDisassemblerInterface;

    public function toArray(): array;

    public function collect(): self;
}