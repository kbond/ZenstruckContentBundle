<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_posts")
 */
class BlogPost extends Page
{
    /**
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    protected $tags;

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
