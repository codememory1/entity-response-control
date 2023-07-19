## Codememory Entity response control
#### TThis library is designed for easy prototyping of API responses. Where your class participates as a prototype of the response from the objects that you give as input

### Install
```shell 
$ composer require codememory/entity-response-control
```

### What will be covered in this documentation?
* How to create your ResponsePrototype ?
* What types of decorators are there?
* What decorators exist?
* How to create your own Collector?
* How to create a context factory?
* How to create your own key naming strategy?
* How to create your own prototype property provider?

### Let's create our ResponsePrototype

> [ ! ] Note that in the ResponsePrototype, all properties we process must have the _"private"_ access modifier, this is the default, if you want to change the creation, write your provider's properties. How to create your providers will be received later

```php
use Codememory\EntityResponseControl\Decorators as RCD;
use Codememory\EntityResponseControl\AbstractResponsePrototype;
use Codememory\EntityResponseControl\Collectors\BaseCollector;
use Codememory\Reflection\ReflectorManager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Codememory\EntityResponseControl\Factory\ConfigurationFactory;
use Codememory\EntityResponseControl\Factory\ExecutionContextFactory;
use Codememory\EntityResponseControl\DecoratorHandlerRegistrar;

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

// Our ResponsePrototype
class UserResponsePrototype extends AbstractResponsePrototype
{
    private ?int $id = null;
    private ?string $name = null;
    
    #[RCD\DateTime] // The default format is Y-m-d H:i:s
    private ?string $createdAt = null;
}

$userResponse = new UserResponsePrototype(
    new BaseCollector(),
    new ConfigurationFactory(),
    new ExecutionContextFactory(),
    new DecoratorHandlerRegistrar(),
    new ReflectorManager(new FilesystemAdapter('entity-response-control', '/var/cache/codememory'))
);
$response = $userResponse->collect(new User())->toArray();
        
// We get the answer in the form of an array:
[
    "id" => 1,
    "name" => "My Name",
    "created_at" => "2023-01-03 00:00"
]
```
> And this is just a small example, on real projects, you can control each property, for example, depending on the permissions of the user or on the type of request and much more

## Let's take a look at the decorators
* __AliasInResponse__ - Display different name in response
  * __$name__: string - Property name in response
* __Prefix__ - Change the prefix of the calling method (default is get) or change the prefix in the response
  * __$prototypeObject__: string | null - Prefix of the getter method from the prototype object from which the value will be obtained
  * __$responsePrefix__: string | null - Prefix in response
* __Custom__ - Custom property, call to get method will be ignored
  * __$methodName__: string - Method name
* __HiddenNullable__ - Hide properties from response that have null values
  * __$ignoreEmptyString (default: true)__: bool - If set to false then properties that have an empty string will also be hidden from the response
* __Count__ - If the property is an array or implements the Countable interface, the count method will be called, if the value is a string, the length of the string will be counted, the response type is always integer
* __ArrayValues__ - Converts a multi array or an array of objects to an array of values
  * __$key__: string - The name of the array key or the name of the method to be called
* __Callback__ - Creating your own callback, this method must be created inside your ResponseControl and the public access modifier
  * __$methodName__: string - Method name
* __NestedPrototype__ - The value of the property will be passed through another ResponseControl. Be careful to use one of the last arguments so you don't end up with a circular dependency
  * __$prototype__: string - Namespace of the ResponseControl class
  * __$skipProperties__: array<string> - Ignore some properties from $prototype
  * __$skipAllPropertiesExpect__: array<string> - Ignore all properties from $prototype except those listed
* __DateTime__ - Expects the property value to be the DateTimeInterface interface, if so, the given object will be converted to the default format or to the format you specify
  * __$format__: string - default(Y-m-d H:i:s) - Format date
  * __$full__: bool - default(false) - If true instead of a string, a DateTime array with full information will be returned
* __XSS__ - Protecting input strings or strings in an array from XSS attack
* __FromEnum__ - Returns an array consisting of key and label from Enum
  * __$enum__: string|null - Namespace Enum if the value is a string, or leave null if the value is already an enum object
* __CropString__ - Trims a string to its maximum length
  * __$maxlength__: INT - Maximum string length
  * __$end__: string - default(...) - Character at the end of a string if the string was truncated
* __PrototypeObjectGetterMethod__ - Set a new name getter name for the prototype object from which the value will be obtained
  * __$name__: string - Method name

### Creating your own decorators

```php
use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Symfony\Component\String\u;

// This decorator will change the getter prefix
#[Attribute(Attribute::TARGET_PROPERTY)]
final class MyDecorator implements DecoratorInterface
{
    public function __construct
    (
        public readonly string $prefix
    ) {}
    
    public function getHandler() : string
    {
        return MyDecoratorHandler::class;
    }
}

// Decorator handler
final class MyDecoratorHandler implements DecoratorHandlerInterface 
{
    // This method can return any result.
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context) : void
    {
        $propertyName = $context->getProperty()->getName();
        
        $context->setNameGetterToGetValueFromObject(u("{$decorator->prefix}_{$propertyName}")->camel()); // Example: isPay
        
        // Update the value by getting it from the new method
        $context->setValue($context->getPrototypeObject()->{$context->getNameGetterToGetValueFromObject()}()); 
    }
}
```

### Registration decorators
```php
// Before calling collect, refer to the configuration
$responsePrototype->getDecoratorHandlerRegistrar()->register(new MyDecoratorHandler());

// Collect prototype...
```

### Consider creating your own Collector
```php
use Codememory\Reflection\ReflectorManager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Codememory\EntityResponseControl\Interfaces\CollectorInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Factory\ExecutionContextFactory;
use Codememory\EntityResponseControl\Factory\ConfigurationFactory;
use Codememory\EntityResponseControl\DecoratorHandlerRegistrar;

class MyObjectCollector implements CollectorInterface {
    public function collect(ResponsePrototypeInterface $responsePrototype, object $prototypeObject, array $properties): array
    {
        $collectedResponse = [];
    
        foreach ($properties as $property) {
            if ($property instanceof PropertyReflector) {
                // Create a context
                $context = $responsePrototype->getExecutionContextFactory()->createExecutionContext($responsePrototype, $property, $prototypeObject);
                foreach ($property->getAttributes() as $attribute) {
                    $decorator = $attribute->getInstance();
                    
                    if ($decorator instanceof DecoratorInterface) {
                        // Getting a decorator handler
                        $decoratorHandler = $responsePrototype->getDecoratorHandlerRegistrar()->getHandler($decorator->getHandler());
                        
                        // Calling a decorator handler
                        $decoratorHandler->handle($decorator, $context);
                    }
                }
                
                // Collecting an array of data
                $collectedResponse[$context->getResponseKey()] = $context->getValue();
            }
        }
        
        return $collectedResponse;
    }
}

// An example of using our UserPrototype with the new Collector

$userResponse = new UserResponse(
    new MyObjectCollector(),
    new ConfigurationFactory(),
    new ExecutionContextFactory(),
    new DecoratorHandlerRegistrar(),
    new ReflectorManager(new FilesystemAdapter('entity-response-control', '/var/cache/codememory'))
);

$userResponse
    ->collect([new User()])
    ->toArray(); // Response to array
```

### How to create a context factory?

```php
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;

// Create a context
final class MyContext implements ExecutionContextInterface
{
    // Implementing Interface Methods...
}

// Creating a context factory
final class MyContextFactory implements ExecutionContextFactoryInterface
{
    public function createExecutionContext(ResponsePrototypeInterface $responsePrototype, PropertyReflector $property, object $prototypeObject): ExecutionContextInterface
    {
        $context = new MyContext();
        // ...
        
        return $context;
    }
}
```

### How to create your own key naming strategy?

> This strategy will look for values in data which was passed to collect as "_{prototype property name}"

```php
use Codememory\EntityResponseControl\Interfaces\ResponseKeyNamingStrategyInterface;

final class MyStrategyName implements ResponseKeyNamingStrategyInterface
{
    private ?\Closure $extension = null;

    public function convert(string $propertyName) : string
    {
        $name =  "_$propertyName";
        
        if (null !== $this->extension) {
            return call_user_func($this->extension, $name);
        }
        
        return $name;
    }
    
    // With this method, you need to give the opportunity to extend the convert method
    public function setExtension(callable $callback) : ResponseKeyNamingStrategyInterface
    {
        $this->extension = $callback;
        
        return $this;
    }
}

$myPrototype = new MyResponsePrototype(new BaseCollector(), new ConfigurationFactory(), ...);

// To use this strategy, you need to change the configuration
$myPrototype->getConfiguration()->setDataKeyNamingStrategy(new MyStrategyName());
```

### How to create your own ResponsePrototype property provider?

> The provider must return the dto properties that are allowed to be processed by the collector! Don't forget to ignore _**AbstractResponsePrototype**_ properties, otherwise these properties will be processed too

```php
use Codememory\EntityResponseControl\Provider\ResponsePrototypePrivatePropertyProvider;
use Codememory\Reflection\Reflectors\ClassReflector;

// The provider will say that only private properties need to be processed
final class MyPropertyProvider implements ResponsePrototypePrivatePropertyProvider
{
    private ?\Closure $extension = null;

    public function getProperties(ClassReflector $classReflector) : array
    {
        $properties = $classReflector->getPrivateProperties();
        
        if (null !== $this->extension) {
            return call_user_func($this->extension, $properties);
        }
        
        return $properties;
    }
    
    // With this method, you need to give the opportunity to extend the getProperties method
    public function setExtension(callable $callback) : ResponsePrototypePrivatePropertyProvider
    {
        $this->extension = $callback;
        
        return $this;
    }
}

$myPrototype = new MyResponsePrototype(new BaseCollector(), new ConfigurationFactory(), ...);

// Change the provider in the configuration
$myPrototype->getConfiguration()->setResponsePrototypePropertyProvider(new MyPropertyProvider());
```