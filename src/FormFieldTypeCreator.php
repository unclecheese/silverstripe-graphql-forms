<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;

class FormFieldTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FormField',
            'description' => 'A SilverStripe form field',
        ];
    }

    public function fields()
    {
        return [
            'name' => ['type' => Type::nonNull(Type::string())],
            'id' => ['type' => Type::nonNull(Type::string())],
            'type' => ['type' => Type::nonNull(Type::string())],
            'schemaType' => ['type' => Type::string()],
            'component' => ['type' => Type::string()],
            'holderId' => ['type' => Type::string()],
            'title' => ['type' => Type::nonNull(Type::string())],
            'source' => ['type' => Type::listOf($this->manager->getType('FormAttribute'))],
            'extraClass' => ['type' => Type::string()],
            'description' => ['type' => Type::string()],
            'rightTitle' => ['type' => Type::string()],
            'leftTitle' => ['type' => Type::string()],
            'readOnly' => ['type' => Type::boolean()],
            'disabled' => ['type' => Type::boolean()],
            'customValidationMessage' => ['type' => Type::string()],
            'validation' => ['type' => Type::listOf(Type::string())],
            'attributes' => ['type' => Type::listOf($this->manager->getType('FormAttribute'))],
            'data' => ['type' => Type::string()],
            'autoFocus' => ['type' => Type::boolean()],
            'children' => ['type' => Type::listOf($this->manager->getType('FormField'))],
            'value' => ['type' => Type::string()],
        ];
    }
}
