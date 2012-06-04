<?php

namespace Soloist\Bundle\BlockBundle\EventListener;

use Soloist\Bundle\CoreBundle\Event\RequestAction;
use Doctrine\ORM\EntityManager;

class SoloistCoreListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onRequestAction(RequestAction $event)
    {
        foreach ($this->em->getRepository('SoloistBlockBundle:Page')->findAll() as $page) {
            $event->addAction(
                'Page-bloc : '.$page->getName(),
                'SoloistBlockBundle:Default:show',
                json_encode(array())
            );
        }
    }
}
