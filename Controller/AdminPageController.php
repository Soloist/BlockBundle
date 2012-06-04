<?php

namespace Soloist\Bundle\BlockBundle\Controller;

use FrequenceWeb\Bundle\DashboardBundle\Controller\ORMCrudController;

use Soloist\Bundle\BlockBundle\Form\Type\PageType,
    Soloist\Bundle\BlockBundle\Entity\Page;

class AdminPageController extends ORMCrudController
{
    /**
     * @return array
     */
    protected function getParams()
    {
        return array(
            'display'        => array(
                'id'   => array('label' => 'N°'),
                'name' => array('label' => 'Nom'),
            ),
            'prefix'         => 'soloist_admin_block_page',
            'singular'       => 'page',
            'plural'         => 'pages',
            'feminine'       => true,
            'form_type'      => new PageType($this->get('soloist.block.page.manager')),
            'class'          => new Page,
            'repository'     => 'SoloistBlockBundle:Page',
            'object_actions' => array(
                'manage_blocks' => array(
                    'label' => 'Gérer les blocs',
                    'route' => 'soloist_admin_block_block_index',
                )
            )
        );
    }
}
