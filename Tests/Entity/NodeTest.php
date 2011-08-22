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

    public function testGetAncestorArray()
    {
        $node = new Node();
        $node->setPath('foo/bar/baz/biz');
        $array = $node->getAncestorArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals(3, count($array));
        $this->assertEquals('foo', $array[0]);
        $this->assertEquals('foo/bar', $array[1]);
        $this->assertEquals('foo/bar/baz', $array[2]);

        $node = new Node();
        $node->setPath('foo/bar');
        $array = $node->getAncestorArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals(1, count($array));
        $this->assertEquals('foo', $array[0]);

        $node = new Node();
        $node->setPath('foo');
        $array = $node->getAncestorArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals(0, count($array));
    }

}
