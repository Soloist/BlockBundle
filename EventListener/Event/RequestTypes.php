<?php

namespace Soloist\Bundle\BlockBundle\EventListener\Event;

use Soloist\Bundle\BlockBundle\Manager\Block;

use Symfony\Component\EventDispatcher\Event;

final class RequestTypes extends Event
{
    /**
     * @var \Soloist\Bundle\BlockBundle\Manager\Block
     */
    private $manager;

    public function __construct(Block $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return \Soloist\Bundle\BlockBundle\Manager\Block
     */
    public function getManager()
    {
        return $this->manager;
    }
}
