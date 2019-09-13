<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class FormStateTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FormState',
            'description' => 'A representation of SilverStripe form state',
        ];
    }

    public function fields()
    {
        return [
            'id' => ['type' => Type::string()],
            'fields' => ['type' => Type::listOf($this->manager->getType('FieldState'))],
            'messages' => ['type' => Type::listOf($this->manager->getType('FormMessage'))],
            'notifyUnsavedChanges' => ['type' => Type::boolean()],
        ];
    }
}
