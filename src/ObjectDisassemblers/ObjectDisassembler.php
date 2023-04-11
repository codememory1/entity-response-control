<?php

namespace Codememory\EntityResponseControl\ObjectDisassemblers;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\ResponseControl;
use Codememory\Reflection\Reflectors\ClassReflector;
use Codememory\Reflection\Reflectors\PropertyReflector;

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

    public function addIgnoreDataProperty(string $name): self
    {
        $this->ignoredDataProperties[] = $name;

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

    public function disassemble(object $object, ResponseControl $responseControl, ClassReflector $classReflector): self
    {
        foreach ($this->getProperties($classReflector) as $property) {
            $constraintTypeControl = new ConstraintTypeControl($responseControl, $property, $object);

            $this->propertyAttributesHandler($classReflector, $property, $constraintTypeControl);
            $this->savePropertyData($constraintTypeControl);
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    private function getProperties(ClassReflector $classReflector): array
    {
        return array_filter(
            $classReflector->getPrivateProperties(),
            function(PropertyReflector $property) use ($classReflector) {
                $notIgnored = !in_array($property->getName(), $this->getIgnoredDataProperties(), true);
                $notIgnoredWithRespectToOnly = [] === $this->getIgnoredAllDataPropertiesExpect() || in_array($property->getName(), $this->getIgnoredAllDataPropertiesExpect(), true);

                return ($classReflector->getName() === $property->getClass()) && $notIgnored && $notIgnoredWithRespectToOnly;
            }
        );
    }

    private function propertyAttributesHandler(ClassReflector $classReflector, PropertyReflector $propertyReflector, ConstraintTypeControl $constraintTypeControl): void
    {
        foreach ($this->getPropertyAttributes($classReflector, $propertyReflector) as $attribute) {
            $attributeInstance = $attribute->getInstance();

            if ($attributeInstance instanceof ConstraintInterface) {
                $typeHandler = $constraintTypeControl->responseControl->getConstraintTypeHandlerRegister()->getHandler($attributeInstance->getType());
                $constraintHandler = $constraintTypeControl->responseControl->getConstraintHandlerRegister()->getHandler($attributeInstance->getHandler());

                $typeHandler->handle($constraintTypeControl, $attributeInstance, $constraintHandler);

                if (!$constraintTypeControl->isAllowedToOutput()) {
                    break;
                }
            }

            if (!$constraintTypeControl->isAllowedToOutput()) {
                break;
            }
        }
    }

    private function getPropertyAttributes(ClassReflector $classReflector, PropertyReflector $propertyReflector): array
    {
        return [
            ...$propertyReflector->getAttributes(),
            ...$classReflector->getAttributes()
        ];
    }

    private function savePropertyData(ConstraintTypeControl $constraintTypeControl): void
    {
        if ($constraintTypeControl->isAllowedToOutput()) {
            $this->data[$constraintTypeControl->getPropertyNameInResponse()] = $constraintTypeControl->getValue();
        }
    }
}