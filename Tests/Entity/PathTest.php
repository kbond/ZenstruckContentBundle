<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Entity;

use Zenstruck\Bundle\ContentBundle\Entity\Path;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class PathTest extends \PHPUnit_Framework_TestCase
{

    public function testSlashesRemoved()
    {
        $path = new Path('foo/bar');

        $this->assertEquals('foo/bar', $path->getUri());

        $path = new Path('/foo/bar');

        $this->assertEquals('foo/bar', $path->getUri());
    }

}
