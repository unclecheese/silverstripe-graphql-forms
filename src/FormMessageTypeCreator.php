<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class FormMessageTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FormMessage',
            'description' => 'A message for a SilverStripe form field',
        ];
    }

    public function fields()
    {
        return [
            'value' => ['type' => Type::string()],
            'type' => ['type' => Type::string()],
        ];
    }
}
