<?php

/*
 * This file is part of the ZenstruckContentBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Sitemap;

use Dpn\XmlSitemapBundle\Sitemap\GeneratorInterface;
use Dpn\XmlSitemapBundle\Sitemap\Entry;
use Zenstruck\Bundle\ContentBundle\Entity\NodeManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class NodeGenerator implements GeneratorInterface
{
    protected $repository;

    protected $method;

    public function __construct(NodeManager $manager, $method)
    {
        $this->repository = $manager->getRepository();
        $this->method = $method;
    }

    /**
     * @return Entry[]
     */
    public function generate()
    {
        /** @var $nodes \Zenstruck\Bundle\ContentBundle\Entity\Node[] */
        $nodes = $this->repository->findAll();

        $entries = array();

        foreach ($nodes as $node) {
            $entry = new Entry();
            $entry->setUri($node->getPath());
            $entry->setLastMod($node->getUpdatedAt());

            $entries[] = $entry;
        }

        return $entries;
    }
}
