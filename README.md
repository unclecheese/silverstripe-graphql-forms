# SilverStripe graphql forms (POC)

Really simple implementation of `FormSchema` in graphql.

## Installation

`$ composer require unclecheese/silverstripe-graphql-forms:dev-master`

## Usage

### Register your forms with`FormQueryCreator`.

```
UncleCheese\GraphQLForms\FormQueryCreator:
  registered_forms:
    ContactForm: 'MyProject\Pages\ContactPageController.ContactForm'
```

In this example, the key `ContactForm` is the name of the form you will pass as an argument
to the `Form` query in graphql (it's an enum).

The value can take on a number of different implementations. Here,
 `'MyProject\Pages\ContactPageController.ContactForm'` refers to `ControllerName.MethodThatReturnsAForm`.
 
 You can also use a fully-qualified `Form` subclass:
 
 ```
ContactForm: 'MyProject\Forms\ContactForm'
```

You can also map it to a method on a `FormFactoryInterface` that is registered with the query creator
(see below).

```
ContactForm: 'myMethod'
```

### Form factories

By default, the forms are generated using the naming conventions above due to the `DefaultFormFactory`
being registered in the `FormQueryCreator`. Its `getFormByName` function resolves the mapping to an
actual `Form` object.

If you have custom ways of generating forms, simply register a new factory.

```php
class MyFormFactory implements FormFactoryInterface
{
  public function getFormByName(string $name): ?Form
  {
    // Get a Form based on $name
  }
}
```

Additionally, to map methods directly to forms, you can subclass `DefaultFormFactory`.

```php
class MyDefaultFormFactory extends DefaultFormFactory
{
  public function MyForm()
  {
    // return instance of MyForm. The parent getFormByName() function checks if
    // this method is defined before advancing through any other logic.
  }
}
```

Don't forget to register your form factories!

```
SilverStripe\Core\Injector\Injector:
  UncleCheese\GraphQLForms\FormQueryCreator:
    properties:
      factories:
        myFactory: '%$MyProject\MyFormFactory'
```

## Caveats

* Methods that generate forms **must be deterministic!** No hiding and showing fields based on state
(at least not yet).
* If you're using an explicit instance of a `Form` subclass, it needs to be instantiable through
`singleton()`. Ensure that any required constructor params are auto-injected.

