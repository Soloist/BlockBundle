<?php

namespace Soloist\Bundle\BlockBundle\Manager;

/**
 * Mangage Page-block datas
 */
class Page
{
    /**
     * @var array
     */
    protected $templates;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->templates = isset($config['templates']) ? $config['templates'] : array();
    }

    /**
     * Returns all the templates
     *
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Return a template file
     *
     * @param $index
     * @return mixed
     */
    public function getTemplate($index)
    {
        return $this->templates[$index];
    }

}
