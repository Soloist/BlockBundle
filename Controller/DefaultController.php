<?php

namespace Soloist\Bundle\BlockBundle\Controller;

use Soloist\Bundle\BlockBundle\Entity\Page;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function showAction(Page $page)
    {
        return $this->render(
            $this->get('soloist.block.page.manager')->getTemplate($page->getTemplate()),
            array('page' => $page)
        );
    }
}
