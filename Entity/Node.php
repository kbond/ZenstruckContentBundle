<?php

namespace Zenstruck\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="content_type", type="string", length=50)
 * @ORM\Entity(repositoryClass="Zenstruck\Bundle\ContentBundle\Repository\NodeRepository")
 * @ORM\Table(name="zenstruck_cms_node")
 */
class Node extends Entity
{
    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\OneToOne(targetEntity="Path", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="path_id", referencedColumnName="id", nullable=true)
     */
    protected $primaryPath;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set primaryPath
     *
     * @param Zenstruck\Bundle\ContentBundle\Entity\Path $primaryPath
     */
    public function setPrimaryPath(Path $primaryPath)
    {
        $this->primaryPath = $primaryPath;
    }

    /**
     * Get primaryPath
     *
     * @return Zenstruck\Bundle\ContentBundle\Entity\Path $primaryPath
     */
    public function getPrimaryPath()
    {
        return $this->primaryPath;
    }
}