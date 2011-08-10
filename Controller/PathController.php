<?php

namespace Zenstruck\Bundle\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PathController extends Controller
{
    public function showAction($uri)
    {
        $node = $this->getDoctrine()->getRepository('ZenstruckContentBundle:Node')->findOneByUri($uri);

        if (!$node) {
            throw $this->createNotFoundException('Node Not Found');
        }

        $templating = $this->get('templating');

        $template = 'ZenstruckContentBundle:CMS:'.$node->getContentType().'.html.twig';

        if ($templating->exists($template)) {
            return $this->render($template, array('node' => $node));
        } else {
            return $this->render('ZenstruckContentBundle:CMS:node.html.twig', array('node' => $node));
        }
    }
}