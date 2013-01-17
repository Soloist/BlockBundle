<?php

namespace Soloist\Bundle\BlockBundle\Form\Type\BlockSettings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form type for accordion blocks
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class AccordionBlockType extends AbstractType
{
    /**
     * @{inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'textarea')
        ;
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'soloist_block_accordion_block_settings';
    }
}
