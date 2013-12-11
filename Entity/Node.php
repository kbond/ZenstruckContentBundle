<?php

/*
 * This file is part of the ZenstruckContentBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Entity;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class Node
{
    protected $id;

    protected $title;

    protected $path;

    protected $updatedAt;

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

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = trim($path, '/');
    }

    /**
     * Returns the an array of ancestors based on the path
     *
     * Example:
     *
     * If path = /foo/bar/baz/bin
     *
     * Returns: array(
     *              'foo',
     *              'foo/bar',
     *              'foo/bar/baz'
     *          )
     *
     * @return array
     */
    public function getAncestorArray()
    {
        $pathArray = explode('/', $this->path);

        array_pop($pathArray);

        $ancestors = array();
        $pathString = null;

        foreach ($pathArray as $path) {

            if (!$pathString) {
                $pathString = $path;
            } else {
                $pathString .= '/'.$path;
            }

            $ancestors[] = $pathString;
        }

        return $ancestors;
    }

}
