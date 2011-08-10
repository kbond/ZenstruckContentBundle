<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Entity;

use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\Node;

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

}
