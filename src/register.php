<?php

use Codememory\EntityResponseControl\Constraints\Availability\HiddenNullableHandler;
use Codememory\EntityResponseControl\Constraints\System\AliasInResponseHandler;
use Codememory\EntityResponseControl\Constraints\System\CustomHandler;
use Codememory\EntityResponseControl\Constraints\System\GetterMethodNameHandler;
use Codememory\EntityResponseControl\Constraints\System\PrefixHandler;
use Codememory\EntityResponseControl\Constraints\Value\ArrayValuesHandler;
use Codememory\EntityResponseControl\Constraints\Value\CallbackHandler;
use Codememory\EntityResponseControl\Constraints\Value\CallbackResponseHandler;
use Codememory\EntityResponseControl\Constraints\Value\CountHandler;
use Codememory\EntityResponseControl\Constraints\Value\CropStringHandler;
use Codememory\EntityResponseControl\Constraints\Value\DateTimeHandler;
use Codememory\EntityResponseControl\Constraints\Value\FromEnumHandler;
use Codememory\EntityResponseControl\Constraints\Value\XSSHandler;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\AvailabilityConstraintHandler;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\SystemConstraintHandler;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Registers\ConstraintHandlerRegister;
use Codememory\EntityResponseControl\Registers\ConstraintTypeHandlerRegister;

ConstraintHandlerRegister::register(new AliasInResponseHandler());
ConstraintHandlerRegister::register(new CustomHandler());
ConstraintHandlerRegister::register(new PrefixHandler());
ConstraintHandlerRegister::register(new GetterMethodNameHandler());

ConstraintHandlerRegister::register(new CountHandler());
ConstraintHandlerRegister::register(new CallbackHandler());
ConstraintHandlerRegister::register(new CallbackResponseHandler());
ConstraintHandlerRegister::register(new DateTimeHandler());
ConstraintHandlerRegister::register(new FromEnumHandler());
ConstraintHandlerRegister::register(new ArrayValuesHandler());
ConstraintHandlerRegister::register(new XSSHandler());
ConstraintHandlerRegister::register(new CropStringHandler());

ConstraintHandlerRegister::register(new HiddenNullableHandler());

ConstraintTypeHandlerRegister::register(new SystemConstraintHandler());
ConstraintTypeHandlerRegister::register(new AvailabilityConstraintHandler());
ConstraintTypeHandlerRegister::register(new ValueConverterConstraintHandler());