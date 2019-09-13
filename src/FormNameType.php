<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\ORM\ArrayLib;

class FormNameType extends EnumSingleton
{
    public function attributes()
    {
        $forms = (array) FormQueryCreator::config()->registered_forms;
        $map = [];
        foreach ($forms as $name => $reference) {
            if (!$reference) {
                continue;
            }
            $map[$name] = $name;
        }
        return [
            'name' => 'FormName',
            'description' => 'A list of registered form names',
            'values' => $map,
        ];
    }


    /**
     * @param string $class
     * @return string
     */
    public static function sanitiseClassName(string $class): string
    {
        return str_replace('\\', '__', $class);
    }

    /**
     * @param string $class
     * @return string
     */
    public static function unsanitiseClassName(string $class): string
    {
        return str_replace('__', '\\', $class);
    }

}
