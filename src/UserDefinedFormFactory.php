<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\CMS\Controllers\ModelAsController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\UserForms\Model\UserDefinedForm;

if (!class_exists(UserDefinedForm::class)) {
    return;
}

class UserDefinedFormFactory implements FormFactoryInterface
{
    public function getFormByName(string $name): ?FormReference
    {
        $page = null;
        if (is_numeric($name)) {
            $page = SiteTree::get_by_id($name);
            if (!$page) {
                return null;
            }
        } else {
            $page = SiteTree::get_by_link($name);
        }

        if (!$page || !$page instanceof UserDefinedForm) {
            return null;
        }

        $controller = ModelAsController::controller_for($page);

        return new FormReference($controller->Form(), $page);
    }
}
