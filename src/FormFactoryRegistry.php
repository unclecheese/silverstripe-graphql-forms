<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\Core\Injector\Injectable;

class FormFactoryRegistry
{
    use Injectable;

    /**
     * @var array
     */
    private $factories = [];

    /**
     * @return FormFactoryInterface[]
     */
    public function getFactories(): array
    {
        return $this->factories;
    }

    /**
     * @param array $factories
     * @return FormFactoryRegistry
     */
    public function setFactories(array $factories): FormFactoryRegistry
    {
        $this->factories = $factories;
        return $this;
    }

}
