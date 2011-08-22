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
        $manager = $this->container->get('zenstruck_content.manager');
        $node = $manager->findOneByPath($uri);

        if (!$node) {
            throw new NotFoundHttpException('Node not found.');
        }

        $breadcrumbs = $manager->getAncestors($node);

        $templating = $this->container->get('templating');

        $parameters = array(
            'node' => $node,
            'breadcrumbs' => $breadcrumbs
        );

        $template = str_replace(':node.', ':'.$node->getContentType().'.', $this->defaultTemplate);

        if ($templating->exists($template)) {
            return $templating->renderResponse($template, $parameters);
        } else {
            return $templating->renderResponse($this->defaultTemplate, $parameters);
        }
    }

}