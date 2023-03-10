<?php

namespace Codememory\EntityResponseControl\Factory;

use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\Registers\ConstraintHandlerRegister;
use Codememory\EntityResponseControl\Registers\ConstraintTypeHandlerRegister;
use Codememory\EntityResponseControl\ResponseControl;

final class ResponseControlFactory
{
    public static function makeResponseControl(
        ObjectDisassemblerInterface $disassembler,
        array $constraintHandlers = [],
        array $constraintTypeHandlers = []
    ): ResponseControl {
        foreach ($constraintHandlers as $constraintHandler) {
            if ($constraintHandler instanceof ConstraintHandlerInterface) {
                ConstraintHandlerRegister::register($constraintHandler);
            }
        }

        foreach ($constraintTypeHandlers as $constraintTypeHandler) {
            if ($constraintTypeHandler instanceof ConstraintTypeHandlerInterface) {
                ConstraintTypeHandlerRegister::register($constraintTypeHandler);
            }
        }

        return new ResponseControl($disassembler);
    }
}