<?php

namespace Zenstruck\Bundle\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NodeController extends Controller
{
    public function showAction($id)
    {
        $node = $this->get('doctrine.orm.entity_manager')->find('ZenstruckCMSBundle:Node', $id);
        
        if (!$node)
            throw $this->createNotFoundException('Node Not Found');
        
        return $this->render('ZenstruckCMSBundle:CMS:' . $node->getContentType() . '.html.twig', array('node' => $node));
    }
}