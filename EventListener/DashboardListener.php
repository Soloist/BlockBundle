<?php

namespace Soloist\Bundle\BlockBundle\EventListener;

use FrequenceWeb\Bundle\DashboardBundle\Menu\Event\Configure;

class DashboardListener
{
    public function onConfigureTopMenu(Configure $event)
    {
        $event
            ->getRoot()
            ->addChild('Blocs', array('route' => 'soloist_admin_block_page_index'))
        ;
    }
}
