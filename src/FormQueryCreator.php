<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Forms\Schema\FormSchema;
use SilverStripe\GraphQL\QueryCreator;

class FormQueryCreator extends QueryCreator
{
    use Configurable;

    // todo: what are we going to do with schema IDs.....?
    const SCHEMA_ID = 'schema';

    /**
     * @var array
     * @config
     */
    private static $registered_forms = [];

    /**
     * @var array
     */
    private $factories = [];

    /**
     * @param array $factories
     * @return FormQueryCreator
     */
    public function setFactories(array $factories): self
    {
        foreach ($factories as $factory) {
            if (!$factory instanceof FormFactoryInterface) {
                throw new ValidationException(sprintf(
                    '%s not passed an instance of %s',
                    __FUNCTION__,
                    FormFactoryInterface::class
                ));
            }

            $this->factories[] = $factory;
        }

        return $this;
    }

    public function attributes()
    {
        return [
            'name' => 'Form',
            'description' => 'Gets a SilverStripe form as structured data (FormSchema)',
        ];
    }

    public function type()
    {
        return $this->manager->getType('Form');
    }

    public function args()
    {
        return [
            'name' => ['type' => Type::nonNull(FormNameType::singleton()->toType())],
        ];
    }

    public function resolve($object, $args = [], $context = [], ResolveInfo $info)
    {
        $formName = $args['name'];
        $forms = static::config()->registered_forms;
        if (!isset($forms[$formName])) {
            throw new InvalidArgumentException(sprintf(
                'Invalid form name "%s"',
                $formName
            ));
        }
        $reference = $forms[$formName];
        foreach ($this->factories as $factory) {
            if ($form = $factory->getFormByName($reference)) {
                $schema = FormSchema::create()
                    ->getMultipartSchema(
                        [FormSchema::PART_SCHEMA, FormSchema::PART_STATE],
                        self::SCHEMA_ID,
                        $form
                    );

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
        $schema = self::normaliseDataAndAttributes($schema);
        foreach (['fields', 'actions'] as $key) {
            foreach ($schema['schema'][$key] as &$fieldData) {
                $fieldData = self::normaliseDataAndAttributes($fieldData);
            }
        }
        foreach ($schema['state']['fields'] as &$fieldData) {
            $fieldData = self::normaliseDataAndAttributes($fieldData);
        }

        return $schema;
    }

    /**
     * @param array $node
     * @return array
     */
    private static function normaliseDataAndAttributes(array $node): array
    {
        foreach (['data', 'attributes'] as $key) {
            if (isset($node[$key])) {
                $node[$key] = self::normaliseMixedArray($node[$key]);
            }
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
