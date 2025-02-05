<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Throwable;

interface ResponsePrototypeExceptionInterface extends Throwable
{
    public function getResponsePrototype(): string;
}