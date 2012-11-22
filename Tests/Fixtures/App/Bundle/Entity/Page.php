<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\Entity;

use Zenstruck\Bundle\ContentBundle\Entity\Node;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages")
 */
class Page extends Node
{
    /**
     * @ORM\Column(name="body", type="string", length=255, nullable=true)
     */
    protected $body;

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}
