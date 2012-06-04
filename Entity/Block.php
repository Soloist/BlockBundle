<?php

namespace Soloist\Bundle\BlockBundle\Entity;

class Block
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \Soloist\Bundle\BlockBundle\Entity\Page
     */
    protected $page;

    /**
     * Block position
     *
     * @var int
     */
    protected $position;

    /**
     * Block type
     *
     * @var string
     */
    protected $type;

    /**
     * Front-office action used for block displaying
     *
     * @var string
     */
    protected $action;

    /**
     * Block settings
     *
     * @var
     */
    protected $settings;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param  $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \Soloist\Bundle\BlockBundle\Entity\Page $page
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return \Soloist\Bundle\BlockBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    public function getRouteParams()
    {
        return array(
            'id' => $this->id
        );
    }

    /**
     * Creates a block from given data.
     * Warning : This method makes no checks, use it... smartly
     *
     * @static
     * @param Page  $page
     * @param array $data
     * @return Block
     */
    static public function createFromData(Page $page, array $data)
    {
        $block = new static();
        $page->addBlock($block);
        $block->setType($data['type']);
        $block->setSettings($data['settings']);
        $block->setAction($data['action']);

        return $block;
    }

}
