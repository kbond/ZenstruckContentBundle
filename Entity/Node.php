<?php

namespace Zenstruck\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class Node extends Entity
{

    /**
     * @var string $path
     */
    protected $path;

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