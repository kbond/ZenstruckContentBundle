<?php

/*
 * This file is part of the ZenstruckRedirectBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
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