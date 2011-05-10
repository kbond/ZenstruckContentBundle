<?php

namespace Zenstruck\Bundle\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NodeController extends Controller
{
    public function showAction($id)
    {
        $node = $this->get('doctrine.orm.entity_manager')->find('CMSBundle:Node', $id);
        
        if (!$node)
            throw $this->createNotFoundException('Node Not Found');
        
        return $this->render('CMSBundle:CMS:' . $node->getContentType() . '.html.twig', array('node' => $node));
    }
}