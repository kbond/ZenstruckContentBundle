<?php

namespace Zenstruck\Bundle\CMSBundle\Entity;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 * 
 * @orm:InheritanceType("JOINED")
 * @orm:DiscriminatorColumn(name="discr", type="string", length=20)
 * @orm:DiscriminatorMap({
 *      "node" = "Node",
 *      "page" = "Page",
 *      "blog_post" = "Zenstruck\ApplicationBundle\Entity\BlogPost"
 * })
 * @orm:Entity
 */
class Node extends Entity
{
    /**
     * @orm:Column(type="string")
     */    
    protected $title;
    
    public function getTitle()     
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}
