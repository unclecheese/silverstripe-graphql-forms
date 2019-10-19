<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class FieldStateTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FieldState',
            'description' => 'The state of a field in a SilverStripe form',
        ];
    }

    public function fields()
    {
        return [
            'name' => ['type' => Type::string()],
            'id' => ['type' => Type::string()],
            'value' => ['type' => Type::string()],
            'message' => ['type' => Type::string()],
            'data' => ['type' => Type::string()],
        ];
    }
}
