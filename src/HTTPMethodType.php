<?php


namespace UncleCheese\GraphQLForms;


class HTTPMethodType extends EnumSingleton
{
    public function attributes()
    {
        return [
            'name' => 'HTTPMethod',
            'values' => [
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'DELETE' => 'DELETE',
                'OPTIONS' => 'OPTIONS',
            ],
        ];
    }
}
