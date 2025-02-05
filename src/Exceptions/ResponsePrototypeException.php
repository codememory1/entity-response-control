<?php

namespace Codememory\EntityResponseControl\Exceptions;

use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeExceptionInterface;
use Exception;
use Throwable;

class ResponsePrototypeException extends Exception implements ResponsePrototypeExceptionInterface
{
    public function __construct(
        private readonly string $responsePrototype,
        string $message,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->message = "Error in {$this->responsePrototype}: {$message}";

        parent::__construct($this->message, $code, $previous);
    }

    public function getResponsePrototype(): string
    {
        return $this->responsePrototype;
    }
}