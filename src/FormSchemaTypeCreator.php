<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\GraphQL\TypeCreator;
use GraphQL\Type\Definition\Type;

class FormSchemaTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FormSchema',
            'description' => 'A SilverStripe form',
        ];
    }

    public function fields()
    {
        return [
            'id' => ['type' => Type::string()],
            'name' => ['type' => Type::string()],
            'action' => ['type' => Type::string()],
            'method' => ['type' => HTTPMethodType::singleton()->toType()],
            'attribtutes' => ['type' => Type::listOf($this->manager->getType('FormAttribute'))],
            'data' => ['type' => Type::listOf($this->manager->getType('FormAttribute'))],
            'fields' => ['type' => Type::listOf($this->manager->getType('FormField'))],
            'actions' => ['type' => Type::listOf($this->manager->getType('FormField'))],
        ];
    }

}
