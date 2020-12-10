<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\GraphQL\Dev\Build;
use SilverStripe\GraphQL\Schema\Exception\SchemaBuilderException;
use SilverStripe\GraphQL\Schema\Interfaces\SchemaUpdater;
use SilverStripe\GraphQL\Schema\Schema;
use SilverStripe\GraphQL\Schema\Type\Enum;

class FormNameCreator implements SchemaUpdater
{
    /**
     * @param Schema $schema
     * @throws SchemaBuilderException
     */
    public static function updateSchema(Schema $schema): void
    {
        $forms = Build::requireActiveBuild()->getSchemaContext()->get('registeredForms', []);
        $map = [];
        foreach ($forms as $name => $reference) {
            if (!$reference) {
                continue;
            }
            $map[$name] = $name;
        }
        $enum = Enum::create(
            'FormName',
            $map,
            'A list of registered form names'
        );
        $schema->addEnum($enum);
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
