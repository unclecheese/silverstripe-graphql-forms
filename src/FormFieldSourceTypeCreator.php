<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\GraphQL\TypeCreator;

class FormFieldSourceTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FormFieldSource',
            'description' => 'Source for a SilverStripe form field, e.g. select/radio',
        ];
    }

    public function fields()
    {
        return [];
    }
}
