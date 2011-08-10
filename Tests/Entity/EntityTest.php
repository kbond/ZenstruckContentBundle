<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Entity;

use Zenstruck\Bundle\ContentBundle\Entity\Entity;
use Zenstruck\Bundle\ContentBundle\Entity\Node;
use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\BlogCommentAuthor;

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
