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
            'name' => ['type' => Type::string()],
            'id' => ['type' => Type::string()],
            'type' => ['type' => Type::string()],
            'schemaType' => ['type' => Type::string()],
            'component' => ['type' => Type::string()],
            'holderId' => ['type' => Type::string()],
            'title' => ['type' => Type::string()],
            'source' => ['type' => $this->manager->getType('FormAttribute')],
            'extraClass' => ['type' => Type::string()],
            'description' => ['type' => Type::string()],
            'rightTitle' => ['type' => Type::string()],
            'leftTitle' => ['type' => Type::string()],
            'readOnly' => ['type' => Type::boolean()],
            'disabled' => ['type' => Type::boolean()],
            'customValidationMessage' => ['type' => Type::string()],
            'validation' => ['type' => Type::listOf(Type::string())],
            'attributes' => ['type' => Type::listOf($this->manager->getType('FormAttribute'))],
            'data' => ['type' => Type::listOf($this->manager->getType('FormAttribute'))],
            'autoFocus' => ['type' => Type::boolean()],
        ];
    }
}
