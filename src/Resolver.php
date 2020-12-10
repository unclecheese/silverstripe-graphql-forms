<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Schema\FormSchema;
use InvalidArgumentException;

class Resolver
{
    // todo: what are we going to do with schema IDs.....?
    const SCHEMA_ID = 'schema';

    public static function resolveForm($object, $args = [])
    {
        $formName = $args['name'];
        // TODO: fetch form config once we have SchemaState API
        $forms = [];
        if (!isset($forms[$formName])) {
            throw new InvalidArgumentException(sprintf(
                'Invalid form name "%s"',
                $formName
            ));
        }
        $reference = $forms[$formName];
        /* @var FormFactoryRegistry $registry */
        $registry = Injector::inst()->get(FormFactoryRegistry::class);
        foreach ($registry->getFactories() as $factory) {
            if ($formReference = $factory->getFormByName($reference)) {
                $schema = FormSchema::create()
                    ->getMultipartSchema(
                        [FormSchema::PART_SCHEMA, FormSchema::PART_STATE],
                        self::SCHEMA_ID,
                        $formReference->getForm()
                    );
                $schema['schema']['formName'] = $formName;
                if ($formReference->getPage()) {
                    $schema['schema']['formPageID'] = $formReference->getPage()->ID;
                }

                return static::normalise($schema);
            }
        }

        throw new InvalidArgumentException(sprintf(
            'Form reference "%s" could not be resolved.',
            $reference
        ));
    }

    /**
     * Remove all the loosely typed arrays and replace with strongly typed attributes
     * @param array $schema
     * @return array
     */
    private static function normalise(array $schema): array
    {
        $schema['schema'] = self::normaliseDataAndAttributes($schema['schema']);
        foreach ($schema['schema']['actions'] as &$fieldData) {
            $fieldData = self::normaliseDataAndAttributes($fieldData);
        }

        $schema['schema']['fields'] = self::removeNullables(
            self::normaliseFields($schema['schema']['fields'])
        );
        $schema['state']['fields'] = self::normaliseFields($schema['state']['fields']);

        return $schema;
    }

    /**
     * @param array $fields
     * @return array
     */
    private static function normaliseFields(array $fields): array
    {
        foreach ($fields as &$fieldData) {
            $validation = $fieldData['validation'] ?? [];
            $rules = [];
            foreach ($validation as $rule => $active) {
                if ($active) {
                    $rules[] = $rule;
                }
            }
            $fieldData['validation'] = $rules;
            $fieldData = self::normaliseDataAndAttributes($fieldData);
            if (!empty($fieldData['children'])) {
                $fieldData['children'] = self::normaliseFields($fieldData['children']);
            } else {
                $fieldData['children'] = [];
            }
        }

        return $fields;
    }

    private static function removeNullables(array $fields): array
    {
        $nonNullables = ['description', 'rightTitle', 'leftTitle'];
        foreach ($fields as &$fieldData) {
            foreach ($nonNullables as $key) {
                if ($fieldData[$key] === null) {
                    $fieldData[$key] = '';
                }
            }
        }

        return $fields;
    }
    /**
     * @param array $node
     * @return array
     */
    private static function normaliseDataAndAttributes(array $node): array
    {
        if (isset($node['data'])) {
            $node['data'] = json_encode($node['data']);
        }
        if (isset($node['attributes'])) {
            $node['attributes'] = self::normaliseMixedArray($node['attributes']);
        }

        return $node;
    }

    /**
     * @param array $data
     * @return array
     */
    private static function normaliseMixedArray(array $data): array
    {
        $map = [];
        foreach($data as $k => $v) {
            $map[] = ['name' => $k, 'value' => $v];
        }

        return $map;
    }

}
