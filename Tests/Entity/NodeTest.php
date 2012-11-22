<?php

/*
 * This file is part of the ZenstruckContentBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Tests\Entity;

use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\Entity\Page;
use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\Entity\BlogPost;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class PathTest extends \PHPUnit_Framework_TestCase
{

    public function testSlashesRemoved()
    {
        $node = new Page();
        $node->setPath('foo/bar');

        $this->assertEquals('foo/bar', $node->getPath());

        $node = new Page();
        $node->setPath('/foo/bar');

        $this->assertEquals('foo/bar', $node->getPath());
    }

    public function testGetContentType()
    {
        $entity = new Page();

        $this->assertEquals('page', $entity->getContentType());

        $entity = new BlogPost();

        $this->assertEquals('blog_post', $entity->getContentType());
    }

    public function testGetAncestorArray()
    {
        $node = new Page();
        $node->setPath('foo/bar/baz/biz');
        $array = $node->getAncestorArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals(3, count($array));
        $this->assertEquals('foo', $array[0]);
        $this->assertEquals('foo/bar', $array[1]);
        $this->assertEquals('foo/bar/baz', $array[2]);

        $node = new Page();
        $node->setPath('foo/bar');
        $array = $node->getAncestorArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals(1, count($array));
        $this->assertEquals('foo', $array[0]);

        $node = new Page();
        $node->setPath('foo');
        $array = $node->getAncestorArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals(0, count($array));
    }

}
