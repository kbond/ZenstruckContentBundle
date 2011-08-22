<?php

namespace Zenstruck\Bundle\ContentBundle\Entity;

use Doctrine\ORM\EntityManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class NodeManager
{
    protected $em;
    protected $class;
    protected $repository;

    /**
     * @param EntityManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    /**
     * @param string $path
     * @return object
     */
    public function findOneByPath($path)
    {
        return $this->repository->findOneByPath($path);
    }

    /**
     * Returns the line of ancestors starting with highest
     *
     * @param Node $node
     */
    public function getAncestors(Node $node)
    {
        $ancestorArray = $node->getAncestorArray();

        // @todo find a better sorting method
        $query = $this->em->createQuery("SELECT n, LENGTH(n.path) as length FROM ".$this->getClass().
                " n WHERE n.path IN ('".  implode("', '", $ancestorArray)."') ".
                "ORDER BY length");

        $results = $query->getResult();

        $ret = array();

        // @todo find a one step hyrdate solution
        // loop thu mixed results to convert to pure
        foreach ($results as $result) {
            $ret[] = $result[0];
        }

        return $ret;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

}
