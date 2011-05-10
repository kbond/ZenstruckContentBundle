<?php

namespace Zenstruck\Bundle\CMSBundle\Entity;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 * 
 * @orm:MappedSuperClass
 * @orm:HasLifecycleCallbacks
 */
class Entity
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue
     */
    protected $id;
    
    /**
     * @var datetime $updatedAt
     *
     * @orm:Column(type="datetime")
     */
    protected $updatedAt;
    
    /**
     * @var datetime $createdAt
     *
     * @orm:Column(type="datetime")
     */
    protected $createdAt;
    
    public function getId()     
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getUpdatedAt()     
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @orm:PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * @orm:PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * Returns the machine name of the class (without namespace)
     */
    public function getContentType()
    {
        preg_match('#([\w]+)$#', get_class($this), $matches);
        $className = $matches[1];
        
        // camel case
        $className = strtolower(preg_replace('#([a-z])([A-Z])#', '$1_$2', $className));
        
        return $className;
    }
}
