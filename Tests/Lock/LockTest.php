<?php

namespace Havvg\Component\Lock\Tests\Lock;

use Havvg\Component\Lock\Lock\Lock;
use Havvg\Component\Lock\Tests\AbstractTest;

/**
 * @covers Havvg\Component\Lock\Lock\Lock
 */
class LockTest extends AbstractTest
{
    public function testAccessors()
    {
        $acquirer = $this->getMockAcquirer();
        $resource = $this->getMockResource();

        $lock = new Lock($acquirer, $resource);

        $this->assertSame($acquirer, $lock->getAcquirer());
        $this->assertSame($resource, $lock->getResource());
    }
}
