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
    protected $contentTypes;

    /**
     * @param EntityManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, $class, $contentTypes)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;

        $this->contentTypes = $contentTypes;
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

        if (empty ($ancestorArray)) {
            return array();
        }

        $class = $this->getClass();

        // @todo find a better sorting method
        // @todo find out why I can't set a :class parameter
        $query = $this->em->createQuery("SELECT n, LENGTH(n.path) as length FROM $class n WHERE n.path IN (:ids) ORDER BY length");

        $query->setParameters(array(
            'ids' => $ancestorArray
        ));

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

    public function getContentTypes()
    {
        return $this->contentTypes;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

}
