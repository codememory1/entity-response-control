<?php

namespace Codememory\EntityResponseControl\Registers;

use Codememory\EntityResponseControl\ConstraintTypeHandlers\AvailabilityConstraintHandler;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\SystemConstraintHandler;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;
use LogicException;
use RuntimeException;

class ConstraintTypeHandlerRegister
{
    protected array $handlers = [];

    public function __construct()
    {
        $this->register(new SystemConstraintHandler());
        $this->register(new AvailabilityConstraintHandler());
        $this->register(new ValueConverterConstraintHandler());
    }

    public function register(ConstraintTypeHandlerInterface $handler): void
    {
        $handlerNamespace = $handler::class;

        if (array_key_exists($handlerNamespace, $this->handlers)) {
            throw new LogicException("The {$handlerNamespace} attribute handler is already registered");
        }

        $this->handlers[$handlerNamespace] = $handler;
    }

    /**
     * @return array<int, ConstraintTypeHandlerInterface>
     */
    public function getHandlers(): array
    {
        return $this->handlers;
    }

    public function getHandler(string $namespace): ConstraintTypeHandlerInterface
    {
        if (!array_key_exists($namespace, $this->handlers)) {
            throw new RuntimeException("Constraint type \"{$namespace}\" not found");
        }

        return $this->handlers[$namespace];
    }
}