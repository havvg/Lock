<?php

namespace Havvg\Component\Lock\Tests;

use Havvg\Component\Lock\Acquirer\AcquirerInterface;
use Havvg\Component\Lock\Lock\LockInterface;
use Havvg\Component\Lock\Repository\RepositoryInterface;
use Havvg\Component\Lock\Resource\ResourceInterface;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AcquirerInterface
     */
    protected function getMockAcquirer()
    {
        return $this->getMock('Havvg\Component\Lock\Acquirer\AcquirerInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|LockInterface
     */
    protected function getMockExpiringLock()
    {
        return $this->getMock('Havvg\Component\Lock\Lock\ExpiringLockInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|LockInterface
     */
    protected function getMockLock()
    {
        return $this->getMock('Havvg\Component\Lock\Lock\LockInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|RepositoryInterface
     */
    protected function getMockRepository()
    {
        return $this->getMock('Havvg\Component\Lock\Repository\RepositoryInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResourceInterface
     */
    protected function getMockResource()
    {
        return $this->getMock('Havvg\Component\Lock\Resource\ResourceInterface');
    }
}
