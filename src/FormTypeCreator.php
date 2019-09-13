<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class FormTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Form',
            'description' => 'A SilverStripe form',
        ];
    }

    public function fields()
    {
        return [
            'schema' => ['type' => $this->manager->getType('FormSchema')],
            'state' => ['type' => $this->manager->getType('FormState')],
        ];
    }
}
