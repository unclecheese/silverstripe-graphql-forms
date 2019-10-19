<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\Forms\Form;

interface FormFactoryInterface
{
    public function getFormByName(string $name): ?FormReference;
}
