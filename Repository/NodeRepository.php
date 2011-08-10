<?php

namespace Zenstruck\Bundle\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

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

}
