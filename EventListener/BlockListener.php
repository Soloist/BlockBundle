<?php

namespace Soloist\Bundle\BlockBundle\EventListener;

use Soloist\Bundle\BlockBundle\EventListener\Event\RequestTypes;
use Soloist\Bundle\BlockBundle\Form\Type\BlockSettings\AccordionBlockType;

/**
 * Listener for block types
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class BlockListener
{
    /**
     * @param RequestTypes $event
     */
    public function onRequestTypes(RequestTypes $event)
    {
        $event->getManager()->addBlockType(
            'accordion_block',
            array(
                'name'          => 'Bloc accordéon',
                'action'        => 'SoloistBlockBundle::',
                'settings'      => array('title' => null, 'description' => null),
                'form'          => new AccordionBlockType,
                'form_template' => 'SoloistBlockBundle:AdminBlock:configureAccordionBlock.html.twig'
            )
        );
    }
}
