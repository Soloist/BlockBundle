<?php

namespace Soloist\Bundle\BlockBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Soloist\Bundle\CoreBundle\Event\RequestAction;

class SoloistCoreListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param RequestAction $event
     */
    public function onRequestAction(RequestAction $event)
    {
        foreach ($this->em->getRepository('SoloistBlockBundle:Page')->findAll() as $page) {
            $event->addAction(
                'Page-bloc : '.$page->getName(),
                'SoloistBlockBundle:Default:show',
                json_encode(array(
                    'slug'  => $page->getSlug(),
                    'route' => 'soloist_block_show',
                ))
            );
        }
    }
}
