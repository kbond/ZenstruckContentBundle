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
