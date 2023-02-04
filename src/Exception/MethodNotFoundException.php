<?php

namespace Codememory\EntityResponseControl\Exception;

use RuntimeException;
use Throwable;

final class MethodNotFoundException extends RuntimeException
{
    public function __construct(object $object, string $method, int $code = 0, ?Throwable $previous = null)
    {
        $objectNamespace = $object::class;

        parent::__construct("Method \"{$method}\" not found in \"{$objectNamespace}\"", $code, $previous);
    }
}