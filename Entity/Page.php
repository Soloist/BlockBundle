<?php

namespace Soloist\Bundle\BlockBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FrequenceWeb\Bundle\DashboardBundle\Crud\CrudableInterface;

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
     * The page slug
     *
     * @var string
     */
    protected $slug;

    /**
     * @var ArrayCollection
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
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * @return array
     */
    public function getRouteParams()
    {
        return array(
            'id' => $this->id
        );
    }

    /**
     * @param  Block $block
     *
     * @return Page
     */
    public function addBlock(Block $block)
    {
        $this->blocks[] = $block;
        $block->setPage($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}
