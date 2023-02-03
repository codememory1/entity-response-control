<?php

namespace Codememory\EntityResponseControl\ObjectDisassemblers;

use Codememory\EntityResponseControl\Adapters\ReflectionAdapter;
use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\Registers\ConstraintHandlerRegister;
use Codememory\EntityResponseControl\Registers\ConstraintTypeHandlerRegister;
use Codememory\EntityResponseControl\ResponseControl;
use ReflectionProperty;

final class ObjectDisassembler implements ObjectDisassemblerInterface
{
    private array $ignoredDataProperties = [];
    private array $ignoredAllDataPropertiesExpect = [];
    private array $data = [];

    public function getIgnoredDataProperties(): array
    {
        return $this->ignoredDataProperties;
    }

    public function setIgnoreDataProperties(array $names): self
    {
        $this->ignoredDataProperties = $names;

        return $this;
    }

    public function getIgnoredAllDataPropertiesExpect(): array
    {
        return $this->ignoredAllDataPropertiesExpect;
    }

    public function setIgnoreAllDataPropertiesExcept(array $names): self
    {
        $this->ignoredAllDataPropertiesExpect = $names;

        return $this;
    }

    public function disassemble(object $object, ResponseControl $responseControl, ReflectionAdapter $reflectionAdapter): self
    {
        $properties = $reflectionAdapter->getControlledProperties($this->getIgnoredDataProperties(), $this->getIgnoredAllDataPropertiesExpect());

        foreach ($properties as $property) {
            $constraintTypeControl = new ConstraintTypeControl($responseControl, $property, $object);

            $this->propertyAttributesHandler($property, $constraintTypeControl);
            $this->savePropertyData($constraintTypeControl);
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    private function propertyAttributesHandler(ReflectionProperty $property, ConstraintTypeControl $constraintTypeControl): void
    {
        foreach ($property->getAttributes() as $attribute) {
            $attributeInstance = $attribute->newInstance();

            if ($attributeInstance instanceof ConstraintInterface) {
                foreach (ConstraintTypeHandlerRegister::getHandlers() as $constraintTypeHandler) {
                    $constraintTypeHandler->handle(
                        $constraintTypeControl,
                        $attributeInstance,
                        ConstraintHandlerRegister::getConstraintHandler($attributeInstance->getHandler())
                    );

                    if (!$constraintTypeControl->isAllowedToOutput()) {
                        break;
                    }
                }
            }

            if (!$constraintTypeControl->isAllowedToOutput()) {
                break;
            }
        }
    }

    private function savePropertyData(ConstraintTypeControl $constraintTypeControl): void
    {
        if ($constraintTypeControl->isAllowedToOutput()) {
            $this->data[$constraintTypeControl->getPropertyNameInResponse()] = $constraintTypeControl->getValue();
        }
    }
}