<?php

namespace Zenstruck\Bundle\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Zenstruck\Bundle\ContentBundle\Entity\Path;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class NodeRepository extends EntityRepository
{

    public function findOneByUri($uri)
    {
        $qb = $this->_em->createQueryBuilder();

        $query = $qb
                ->select('n, p')
                ->from('ZenstruckContentBundle:Node', 'n')
                ->leftJoin('n.primaryPath', 'p')
                ->where('p.uri = :uri')->setParameter('uri', $uri)
                ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByPath(Path $path)
    {
        $qb = $this->_em->createQueryBuilder();

        $query = $qb
                ->select('n')
                ->from('ZenstruckContentBundle:Node', 'n')
                ->where('n.primaryPath = :nodeId')->setParameter('nodeId', $path->getId())
                ->getQuery();

        return $query->getOneOrNullResult();
    }

}
