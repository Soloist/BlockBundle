<?php

namespace Soloist\Bundle\BlockBundle\Manager;

use Soloist\Bundle\BlockBundle\EventListener\Event\RequestTypes,
    Soloist\Bundle\BlockBundle\EventListener\BlockEvents;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Block
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var array
     */
    protected $blockTypes = array();

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher)
    {
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * Add a block type to the manager
     * $params must looks like [
     *   'name'     => 'Last news',
     *   'action    => 'SoloistBlogBundle:Default:showLasts'
     *   'settings' => [
     *      ...
     *   ]
     * ]
     *
     * @param $name
     * @param array $params
     */
    public function addBlockType($type, array $params)
    {
        $this->blockTypes[$type] = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getBlockTypes()
    {
        if (0 === count($this->blockTypes)) {
            $this->retrieveBlockTypes();
        }

        return $this->blockTypes;
    }


    public function getBlockType($type)
    {
        if (0 === count($this->blockTypes)) {
            $this->retrieveBlockTypes();
        }

        return $this->blockTypes[$type];
    }

    protected function retrieveBlockTypes()
    {
        $this->eventDispatcher->dispatch(BlockEvents::onRequestTypes, new RequestTypes($this));
    }
}
