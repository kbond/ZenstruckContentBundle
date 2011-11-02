<?php

/*
 * This file is part of the ZenstruckRedirectBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class Entity
{
    protected $id;

    protected $title;

    /**
     * @var datetime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var datetime $createdAt
     */
    protected $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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

    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function __toString()
    {
        return (string) $this->getTitle();
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