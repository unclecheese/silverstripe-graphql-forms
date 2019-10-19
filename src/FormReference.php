<?php


namespace UncleCheese\GraphQLForms;


use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\Form;

class FormReference
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var SiteTree|null
     */
    private $page;

    /**
     * FormReference constructor.
     * @param Form $form
     * @param SiteTree|null $page
     */
    public function __construct(Form $form, SiteTree $page = null)
    {
        $this->form = $form;
        $this->page = $page;
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * @return SiteTree|null
     */
    public function getPage(): ?SiteTree
    {
        return $this->page;
    }

}
