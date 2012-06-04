<?php

namespace Soloist\Bundle\BlockBundle\Form\Type;

use Soloist\Bundle\BlockBundle\Manager\Page;

use Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\AbstractType;

class PageType extends AbstractType
{
    /**
     * @var \Soloist\Bundle\BlockBundle\Manager\Page
     */
    protected $pageManager;

    /**
     * @param \Soloist\Bundle\BlockBundle\Manager\Page $pageManager
     */
    public function __construct(Page $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array_keys($this->pageManager->getTemplates());
        $builder
            ->add('name')
            ->add('template', 'choice', array('choices' => array_combine($choices, $choices)))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'soloist_block_block';
    }
}
