<?php

namespace Zenstruck\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NodeController
{
    protected $container;
    protected $defaultTemplate;

    /**
     * @param EntityManager $em
     * @param string $defaultTemplate
     */
    public function __construct(Container $container, $defaultTemplate)
    {
        $this->container = $container;
        $this->defaultTemplate = $defaultTemplate;
    }

    public function showAction($uri)
    {
        $repository = $this->container->get('doctrine')->getEntityManager()->getRepository('ZenstruckContentBundle:Node');
        $node = $repository->findOneByPath($uri);

        if (!$node) {
            throw new NotFoundHttpException('Node not found.');
        }

        $templating = $this->container->get('templating');

        $template = str_replace(':node.', ':'.$node->getContentType().'.', $this->defaultTemplate);

        if ($templating->exists($template)) {
            return $templating->renderResponse($template, array('node' => $node));
        } else {
            return $templating->renderResponse($this->defaultTemplate, array('node' => $node));
        }
    }

}