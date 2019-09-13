<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\Control\Controller;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Form;
use BadMethodCallException;
use SilverStripe\ORM\ValidationException;

class DefaultFormFactory implements FormFactoryInterface
{
    public function getFormByName(string $name): ?Form
    {
        if (method_exists($this, $name)) {
            $form = $this->$name();
            if (!$form instanceof Form) {
                throw new ValidationException(sprintf(
                    'Method "%s" on %s did not return a Form instance',
                    $name,
                    get_class($this)
                ));
            }

            return $form;
        }

        if ($name instanceof Form) {
            try {
                $form = $name::singleton();
            } catch (\Exception $e) {
                throw new BadMethodCallException(sprintf(
                    'Could not instantiate form of class %s as a singleton. Please make sure it does not have any
                    required constructor args, or add them into injector. Full error: %s',
                    $name,
                    $e->getMessage()
                ));
            }

            return $form;
        }

        if (strpos($name, '.') !== false) {
            list ($controller, $method) = explode('.', $name);
            if (!is_subclass_of($controller, Controller::class)) {
                throw new ValidationException(sprintf(
                    '%s is not a controller for form "%s"',
                    $controller,
                    $method
                ));
            }
            $controller = Injector::inst()->create($controller);

            if (!method_exists($controller, $method)) {
                throw new ValidationException(sprintf(
                    '%s is not a controller for form "%s"',
                    $controller,
                    $method
                ));
            }

            $form = $controller->$method();

            if (!$form instanceof Form) {
                throw new ValidationException(sprintf(
                    'Controller %s did not return a Form instance for method "%s"',
                    $controller,
                    $method
                ));
            }

            return $form;
        }

        return null;
    }
}
