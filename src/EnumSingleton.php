<?php


namespace UncleCheese\GraphQLForms;


use GraphQL\Type\Definition\EnumType;
use SilverStripe\GraphQL\TypeCreator;

// @todo: duplicate of silverstripe-gatsby. Maybe move into core?
abstract class EnumSingleton extends TypeCreator
{
    /**
     * @var EnumType
     */
    private $type;

    public function toType()
    {
        if (!$this->type) {
            $this->type = new EnumType($this->toArray());
        }
        return $this->type;
    }

    public function getAttributes()
    {
        return $this->attributes();
    }

}
