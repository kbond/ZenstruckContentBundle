<?php
namespace Zenstruck\Bundle\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Zenstruck\Bundle\CMSBundle\Entity\Node;
use Zenstruck\Bundle\CMSBundle\Entity\Page;

class FixtureLoader implements FixtureInterface
{    
    
    public function load($manager)
    {
        
        $node1 = new Node();
        $node1->setTitle('Node 1');
        $manager->persist($node1);
        
        $node2 = new Node();
        $node2->setTitle('Node 2');
        $manager->persist($node2);
        
        $node3 = new Node();
        $node3->setTitle('Node 3');
        $manager->persist($node3);
        
        $page1 = new Page();
        $page1->setTitle('Page 1');
        $page1->setBody('Lorem ipsum');
        $manager->persist($page1);
        
        $page2 = new Page();
        $page2->setTitle('Page 2');
        $page2->setBody('Lorem ipsum');
        $manager->persist($page2);
        
        $manager->flush();
    }
    
}
