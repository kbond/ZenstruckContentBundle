<?php

namespace Zenstruck\Bundle\ContentBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class Node extends Entity
{
    /**
     * @Assert\NotBlank()
     * 
     * @var string $title
     */
    protected $title;

    /**
     * @var string $path
     */
    protected $path;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = trim($path, '/');
    }
}