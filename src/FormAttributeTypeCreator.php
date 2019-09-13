<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class FormAttributeTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FormAttribute',
            'description' => 'An attribute for a SilverStripe form',
        ];
    }

    public function fields()
    {
        return [
            'name' => ['type' => Type::string()],
            'value' => ['type' => Type::string()],
        ];
    }
}
