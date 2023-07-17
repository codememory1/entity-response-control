<?php

namespace Codememory\EntityResponseControl\Exception;

use RuntimeException;
use Throwable;

final class ResponsePrototypeNotFoundException extends RuntimeException
{
    public function __construct(string $namespace, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Class ResponsePrototype with namespace \"{$namespace}\" not found", $code, $previous);
    }
}