<?php

namespace Soloist\Bundle\BlockBundle\Controller;

use Soloist\Bundle\BlockBundle\Entity\Page,
    Soloist\Bundle\BlockBundle\Entity\Block;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class AdminBlockController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Page $page)
    {
        $this->get('fw_breadcrumbs')
            ->add('Tableau de bord', array('route' => 'fw_dashboard_index'))
            ->add('Gestion des pages-blocs', array('route' => 'soloist_admin_block_page_index'))
            ->add('Page "'.$page->getName().'"', array(
                'route'        => 'soloist_admin_block_page_edit',
                'route_params' => $page->getRouteParams()
            ))
            ->add('Gérer les blocs')
        ;

        return array('page' => $page);
    }

    /**
     * @Template()
     */
    public function getBlocksAction(Page $page)
    {
        return array('page' => $page, 'manager' => $this->get('soloist.block.manager'));
    }

    /**
     * @Template()
     */
    public function listBlockTypesAction()
    {
        return array('blocks' => $this->get('soloist.block.manager')->getBlockTypes());
    }

    public function addAction(Page $page, Request $request)
    {
        $em    = $this->getDoctrine()->getEntityManager();
        $block = Block::createFromData($page, $request->request->all());
        $em->persist($block);
        $em->flush();

        return new Response(json_encode(array(
            'blocks' => $this->container->get('templating.helper.actions')->render(
                'SoloistBlockBundle:AdminBlock:getBlocks',
                array('page' => $page)
            ),
            'library' =>$this->container->get('templating.helper.actions')->render(
                'SoloistBlockBundle:AdminBlock:listBlockTypes'
            )
        )));
    }

    /**
     * @Template("SoloistBlockBundle:AdminBlock:getBlocks.html.twig")
     */
    public function deleteAction(Block $block)
    {
        $page = $block->getPage();
        $em   = $this->getDoctrine()->getEntityManager();
        $em->remove($block);
        $em->flush();

        return array('page' => $page, 'manager' => $this->get('soloist.block.manager'));
    }

    /**
     * @Template()
     */
    public function configureAction(Block $block, Request $request)
    {
        $manager   = $this->get('soloist.block.manager');
        $blockType = $manager->getBlockType($block->getType());
        $form = $this->get('form.factory')->create($blockType['form'], $block->getSettings());

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $block->setSettings($form->getData());
                $this->getDoctrine()->getEntityManager()->flush();
            }
        }

        return array('block' => $block, 'block_type' => $blockType, 'form' => $form->createView());
    }

    public function sortAction(Block $block, Request $request)
    {
        $position = $request->query->get('position', 0);
        $block->setPosition($position);
        $this->getDoctrine()->getEntityManager()->flush();

        return new Response(json_encode(array('success' => true)));
    }
}
