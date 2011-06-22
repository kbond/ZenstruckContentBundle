<?php
namespace Zenstruck\Bundle\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Zenstruck\Bundle\CMSBundle\Entity\Node;
use Zenstruck\Bundle\CMSBundle\Entity\Path;

class FixtureLoader implements FixtureInterface
{

    public function load($manager)
    {
        $node1 = new Node();
        $node1->setTitle('Node 1');
        $node1->setPrimaryPath(new Path('path/to/node/1'));
        $manager->persist($node1);

        $node2 = new Node();
        $node2->setTitle('Node 2');
        $node2->setPrimaryPath(new Path('<front>'));
        $manager->persist($node2);

        $node3 = new Node();
        $node3->setTitle('Node 3');
        $node3->setPrimaryPath(new Path('path/to/node/3'));
        $manager->persist($node3);

        $manager->flush();
    }

}
