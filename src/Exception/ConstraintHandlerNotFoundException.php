<?php

namespace Codememory\EntityResponseControl\Exception;

use RuntimeException;
use Throwable;

final class ConstraintHandlerNotFoundException extends RuntimeException
{
    public function __construct(string $namespace, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Constraint handler with namespace \"{$namespace}\" not found", $code, $previous);
    }
}