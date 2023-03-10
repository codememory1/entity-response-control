<?php

namespace Codememory\EntityResponseControl\Registers;

use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;
use LogicException;

class ConstraintTypeHandlerRegister
{
    protected static array $handlers = [];

    public static function register(ConstraintTypeHandlerInterface $handler): void
    {
        $handlerNamespace = $handler::class;

        if (array_key_exists($handlerNamespace, static::$handlers)) {
            throw new LogicException("The {$handlerNamespace} attribute handler is already registered");
        }

        static::$handlers[$handlerNamespace] = $handler;
    }

    /**
     * @return array<int, ConstraintTypeHandlerInterface>
     */
    public static function getHandlers(): array
    {
        return static::$handlers;
    }
}