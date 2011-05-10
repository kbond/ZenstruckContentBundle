<?php

namespace Zenstruck\Bundle\CMSBundle\Entity;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 * 
 * @orm:Entity
 */
class Page extends Node
{
    /**
     * @orm:Column(type="text", nullable=true)
     */  
    protected $body;
    
    public function getBody()     
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }


}
