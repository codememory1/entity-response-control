## Codememory Entity response control
#### This library was created to simplify the normalization of data from an object to an array and is well suited for working with Doctrine Entity. Now you do not need to create groups or write additional methods for API responses, entity-response-control will take care of this

### Install
```shell 
$ composer require codememory/entity-response-control
```

### What will be covered in this documentation?
* How to create your ResponseControl ?
* What types of constraints are there?
* What constraints exist?
* How to create your own Disassembler?

### Let me first tell you about constraint priority
> There are currently 3 types of constructs in the library: System, Availability, ValueConverter (Value)
> * System - Intended for managing properties, whether it be to change the method prefix or change the name in the response
> * Availability - Intended to control the availability of a property in the response, i.e. if the construct fails the test and returns false in the handler, the property will not be available in the response and all subsequent constructs will not be executed and iteration will go to the next property
> * ValueConverter aka Value - Designed to manage the value of a property, it's simple
> * I want to note that these types are enough for large projects, but if they are not enough for you, you can create your own at any time - we will consider this a little later
> Priority - Observe the priorities of constraint calls so as not to lose performance. For example: Try to call System constraints at the very beginning, then Availability, and then ValueConverter, but if your own types exist, then rely on them

### Let's create our ResponseControl

> [ ! ] Please note that in the ResponseControl, all properties that we process must have the access modifier _"private"_

```php 
use Codememory\EntityResponseControl\Constraints\Value as RDCV;
use Codememory\EntityResponseControl\ResponseControl;
use Codememory\EntityResponseControl\ObjectDisassemblers\ObjectDisassembler;

// We have some entity User
class User {
    private int $id = 1;
    private string $name = 'My Name';
    
    public function getId(): int 
    {
        return $this->id;
    }
    
    public function getName(): string 
    {
        return $this->name;
    }
    
    public function getCreatedAt(): DateTimeInterface
    {
        return new DateTime();
    }
}

# Our ResponseControl
class UserResponse extends ResponseControl
{
    private ?int $id = null;
    private ?string $name = null;
    
    #[RDCV\DateTime] // The default format is Y-m-d H:i:s
    private ?string $createdAt = null;
}

$userResponse = new UserResponse(new ObjectDisassembler());
$response = $userResponse
        ->setData(new User())
        ->collect()
        ->toArray();
        
// We get the answer in the form of an array:
[
    "id" => 1,
    "name" => "My Name",
    "created_at" => "2023-01-03 00:00"
]
```
> And this is just a small example, on real projects, you can control each property, for example, depending on the permissions of the user or on the type of request and much more

## Let's take a look at the constructs
* System
  * AliasInResponse - Display different name in response
    * $name: string - Property name in response
  * Prefix - Change the prefix of the calling method (default is get) or change the prefix in the response
    * $methodPrefix: string | null - Prefix method
    * $responsePrefix: string | null - Prefix in response
  * AsCustom - Custom property, call to get method will be ignored
    * $methodName: string - Method name


* Availability - There are none available, because basically these constructs depend on the logic of your application. Below is an example of how to create such constructs


* ValueConverter
  * AsCount - If the property is an array or implements the Countable interface, the count method will be called, if the value is a string, the length of the string will be counted, the response type is always integer
  * Callback - Creating your own callback, this method must be created inside your ResponseControl and the public access modifier
    * $methodName: string - Method name
  * CallbackResponse - The value of the property will be passed through another ResponseControl. Be careful to use one of the last arguments so you don't end up with a circular dependency
    * $responseControl: string - Namespace of the ResponseControl class
    * $ignoreProperties: array<string> - Ignore some properties from $responseControl
    * $onlyProperties: array<string> - Ignore all properties from $responseControl except those listed
  * DateTime - Expects the property value to be the DateTimeInterface interface, if so, the given object will be converted to the default format or to the format you specify
    * $format: string : default: 'Y-m-d H:i:s'

### Creating your own constraints

```php
#!!! System Constraint
use Attribute;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;
use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\AvailabilityConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;

// Constraint for changing the prefix when calling a method
#[Attribute(Attribute::TARGET_PROPERTY)]
final class MySystem implements ConstraintInterface
{
    public function __construct
    (
        public readonly string $prefix
    ) {}
    
    public function getHandler() : string
    {
        return MySystemHandler::class;
    }
}

// Constraint handler
final class MySystemHandler implements SystemConstraintHandlerInterface 
{
    // This method can return any result.
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl) : mixed
    {
        $constraintTypeControl->setPrefixMethod($constraint->prefix); // Setting up a new prefix
        
        // Update the value by getting it from the new method
        $constraintTypeControl->setValue($constraintTypeControl->object->{$constraintTypeControl->getMethodName()}()); 
        
        // $this->object - One of the objects you passed to setData in your ResponseControl
        // $constraintTypeControl->getMethodName() - Generates method name based on prefix and property name
        
        return true;
    }
}

#!!! Availability Constraint

// Constraint, by checking if a particular value from object will not match the current value
#[Attribute(Attribute::TARGET_PROPERTY)]
final class MyAvailability implements ConstraintInterface
{
    public function __construct
    (
        public readonly string $withProperty
    ) {}
    
    public function getHandler() : string
    {
        return MyAvailabilityHandler::class;
    }
}

final class MyAvailabilityHandler implements AvailabilityConstraintHandlerInterface 
{
    // false - The property will be forbidden displayed in response
    // true - The property will be displayed in response
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl) : bool
    {
        // Get value from $withProperty
        // Generate a method name for it
        $withMethodName = 'get'.ucfirst($constraint->withProperty);
        
        // Getting the value
        $withValue = $constraintTypeControl->object->{$withMethodName}();
        
        // Compare the value of $withValue with the current value of the property
        return $constraintTypeControl->getValue() === $withValue;
    }
}

#!!! ValueConverter Constraint

// Constraint for converting text to lowercase
final class MyValueConverter implements ConstraintInterface
{
    public function __construct
    (
        public readonly string $withProperty
    ) {}
    
    public function getHandler() : string
    {
        return MyValueConverterHandler::class;
    }
}

final class MyValueConverterHandler implements ValueConverterConstraintHandlerInterface 
{
    public function handle(ConstraintInterface $constraint,ConstraintTypeControl $constraintTypeControl) : string
    {
        // Convert to lowercase if the value is a string
        if (is_string($constraintTypeControl->getValue())) {
            return mb_strtolower($constraintTypeControl->getValue());
        }
        
        // Otherwise return the current value
        return $constraintTypeControl->getValue();
    }
}
```

### Registration of exhibits
```php
#!!! Please note that the registration of the constructs must be done before the build is executed.
use Codememory\EntityResponseControl\Registers\ConstraintHandlerRegister;

ConstraintHandlerRegister::register(new MySystemHandler());
ConstraintHandlerRegister::register(new MyAvailabilityHandler());
ConstraintHandlerRegister::register(new MyValueConverterHandler());
```

### Creating your own content type
```php
use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;
use Codememory\EntityResponseControl\ConstraintTypeControl;

interface MyConstraintTypeInterface extends ConstraintHandlerInterface
{

}

// The type of constraint that will handle the constraint handlers and if it returns an array, we will take the last element of this array and store it as a value in the Response property
final MyConstraintType implements ConstraintTypeHandlerInterface
{
    public function handle(ConstraintTypeControl $constraintTypeControl, ConstraintInterface $constraint, ConstraintHandlerInterface $handler): void
    {
        if ($handler instanceof MyConstraintTypeInterface) {
            $handleResult = $handler->handle($constraint, $constraintTypeControl);
            
            if (is_array($handleResult)) {
                $constraintTypeControl->setValue($handleResult[array_key_last($handleResult)]);
            }
        }
    }
}
```
### Registering Constraint Types
```php
<?php
#!!! Registration of types of constraint must be carried out before the work of the collector itself
use Codememory\EntityResponseControl\Registers\ConstraintTypeHandlerRegister;

ConstraintTypeHandlerRegister::register(new MyConstraintType());
```

### Consider creating your own Disassembler
```php
#!!! All work takes place in the Disassembler and the creation of the Disassembler itself is not recommended.

use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\Adapters\ReflectionAdapter;

class MyObjectDisassembler implements ObjectDisassemblerInterface {
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
    
    public function toArray(): array
    {
        return $this->data;
    }
    
    public function disassemble(object $object, ResponseControl $responseControl, ReflectionAdapter $reflectionAdapter): self
    {
        // Get the properties of the ResponseControl
        foreach ($reflectionAdapter->getControlledProperties() as $property) {
            // Getting property attributes
            foreach ($property->getAttributes() as $attribute) {
                // We start processing properties by creating our own ConstraintTypeControl logic...
            }
        }
    }
}

// An example of using our UserResponse with the new Disassembler

$userResponse = new UserResponse(new MyObjectDisassembler());

$userResponse
    ->setData([new User()])
    ->collect()
    ->toArray(); // Response to array
```