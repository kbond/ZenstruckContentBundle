<?php

namespace Zenstruck\Bundle\CMSBundle\Tests\Entity;

use Zenstruck\Bundle\CMSBundle\Entity\Entity;
use Zenstruck\Bundle\CMSBundle\Entity\Node;
use Zenstruck\Bundle\CMSBundle\Tests\Fixtures\BlogCommentAuthor;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContentType()
    {
        $entity = new Entity();
        
        $this->assertEquals('entity', $entity->getContentType());
        
        $entity = new BlogCommentAuthor();
        
        $this->assertEquals('blog_comment_author', $entity->getContentType());        
    }
}
