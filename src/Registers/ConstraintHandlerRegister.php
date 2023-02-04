<?php

namespace Codememory\EntityResponseControl\Registers;

use Codememory\EntityResponseControl\Exception\ConstraintHandlerNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use LogicException;

class ConstraintHandlerRegister
{
    protected static array $handlers = [];

    public static function register(ConstraintHandlerInterface $constraintHandler): void
    {
        $constraintHandlerNamespace = $constraintHandler::class;

        if (array_key_exists($constraintHandlerNamespace, static::$handlers)) {
            throw new LogicException("Constraint handler {$constraintHandlerNamespace} is already registered");
        }

        static::$handlers[$constraintHandlerNamespace] = $constraintHandler;
    }

    public static function getConstraintHandler(string $namespace): ?ConstraintHandlerInterface
    {
        if (!array_key_exists($namespace, static::$handlers)) {
            throw new ConstraintHandlerNotFoundException($namespace);
        }

        return static::$handlers[$namespace] ?? null;
    }
}