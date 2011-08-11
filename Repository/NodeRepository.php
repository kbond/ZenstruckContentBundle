<?php

namespace Zenstruck\Bundle\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\Query;
/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class NodeRepository extends EntityRepository
{
    public function findOneByPath($uri, $refresh = true)
    {
        $node = $this->findOneBy(array('path' => $uri));
        if ($refresh) {
            $this->_em->refresh($node);
        }

        return $node;
    }

}
