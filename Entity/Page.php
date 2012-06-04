<?php

namespace Soloist\Bundle\BlockBundle\Entity;

use FrequenceWeb\Bundle\DashboardBundle\Crud\CrudableInterface;

use Doctrine\Common\Collections\ArrayCollection;

class Page implements CrudableInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * The template used to display the page
     *
     * @var string
     */
    protected $template;

    /**
     * The page name (used for identification)
     *
     * @var string
     */
    protected $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $blocks;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->blocks = new ArrayCollection;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
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

    public function getRouteParams()
    {
        return array(
            'id' => $this->id
        );
    }

    public function addBlock(Block $block)
    {
        $this->blocks[] = $block;
        $block->setPage($this);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

}
