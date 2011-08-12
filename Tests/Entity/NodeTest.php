<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Entity;

use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\Node;
use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\BlogCommentAuthor;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class PathTest extends \PHPUnit_Framework_TestCase
{

    public function testSlashesRemoved()
    {
        $node = new Node();
        $node->setPath('foo/bar');

        $this->assertEquals('foo/bar', $node->getPath());

        $node = new Node();
        $node->setPath('/foo/bar');

        $this->assertEquals('foo/bar', $node->getPath());
    }

    public function testGetContentType()
    {
        $entity = new Node();

        $this->assertEquals('node', $entity->getContentType());

        $entity = new BlogCommentAuthor();

        $this->assertEquals('blog_comment_author', $entity->getContentType());
    }

}
