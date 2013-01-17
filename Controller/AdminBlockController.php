<?php

namespace Soloist\Bundle\BlockBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Soloist\Bundle\BlockBundle\Entity\Block;
use Soloist\Bundle\BlockBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBlockController extends Controller
{
    /**
     * @Template
     *
     * @param  Page  $page
     *
     * @return array
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
     * @Template
     *
     * @param  Page  $page
     *
     * @return array
     */
    public function getBlocksAction(Page $page)
    {
        return array('page' => $page, 'manager' => $this->get('soloist.block.manager'));
    }

    /**
     * @Template
     *
     * @return array
     */
    public function listBlockTypesAction()
    {
        return array('blocks' => $this->get('soloist.block.manager')->getBlockTypes());
    }

    /**
     * @param  Page     $page
     * @param  Request  $request
     *
     * @return Response
     */
    public function addAction(Page $page, Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
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
     *
     * @param  Block         $block
     *
     * @return array<string>
     */
    public function deleteAction(Block $block)
    {
        $page = $block->getPage();
        $em   = $this->getDoctrine()->getManager();
        $em->remove($block);
        $em->flush();

        return array('page' => $page, 'manager' => $this->get('soloist.block.manager'));
    }

    /**
     * @param  Block    $block
     * @param  Request  $request
     *
     * @return Response
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
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->render(
            isset($blockType['form_template']) ? $blockType['form_template'] : 'SoloistBlockBundle:AdminBlock:configure.html.twig',
            array('block' => $block, 'block_type' => $blockType, 'form' => $form->createView())
        );
    }

    /**
     * @param  Block    $block
     * @param  Request  $request
     *
     * @return Response
     */
    public function sortAction(Block $block, Request $request)
    {
        $position = $request->query->get('position', 0);
        $block->setPosition($position);
        $this->getDoctrine()->getManager()->flush();

        return new Response(json_encode(array('success' => true)));
    }
}
