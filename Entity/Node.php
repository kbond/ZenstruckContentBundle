<?php

namespace Zenstruck\Bundle\CMSBundle\Entity;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 * 
 * @orm:InheritanceType("JOINED")
 * @orm:DiscriminatorColumn(name="content_type", type="string", length=50)
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
