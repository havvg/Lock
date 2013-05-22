<?php

namespace Havvg\Component\Lock\Tests;

use Havvg\Component\Lock\LockManager;

/**
 * @covers Havvg\Component\Lock\LockManager
 */
class LockManagerTest extends AbstractTest
{
    public function testNotLockedResourceIsAccessible()
    {
        $acquirer = $this->getMockAcquirer();

        $repository = $this->getMockRepository();

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(false))
        ;

        $manager = new LockManager($repository);

        $this->assertTrue($manager->isAccessible($acquirer, $resource),
            'A Resource which is not locked is accessible.');
    }

    public function testLockedResourceIsAccessibleByAcquirer()
    {
        $acquirer = $this->getMockAcquirer();
        $acquirer
            ->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue('MockAcquirer'))
        ;

        $lock = $this->getMockLock();
        $lock
            ->expects($this->once())
            ->method('getAcquirer')
            ->will($this->returnValue($acquirer))
        ;

        $repository = $this->getMockRepository();

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(true))
        ;
        $resource
            ->expects($this->once())
            ->method('getLock')
            ->will($this->returnValue($lock))
        ;

        $manager = new LockManager($repository);

        $this->assertTrue($manager->isAccessible($acquirer, $resource),
            'A locked Resource is accessible by the Acquirer of the Lock.');
    }

    public function testLockedResourceIsNotAccessibleByOthers()
    {
        $acquirer = $this->getMockAcquirer();
        $acquirer
            ->expects($this->once())
            ->method('getIdentifier')
            ->will($this->returnValue('MockAcquirer'))
        ;

        $requester = $this->getMockAcquirer();
        $requester
            ->expects($this->once())
            ->method('getIdentifier')
            ->will($this->returnValue('RequestingAcquirer'))
        ;

        $lock = $this->getMockLock();
        $lock
            ->expects($this->once())
            ->method('getAcquirer')
            ->will($this->returnValue($acquirer))
        ;

        $repository = $this->getMockRepository();

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(true))
        ;
        $resource
            ->expects($this->once())
            ->method('getLock')
            ->will($this->returnValue($lock))
        ;

        $manager = new LockManager($repository);

        $this->assertFalse($manager->isAccessible($requester, $resource),
            'A locked Resource is not accessible by other Acquirers.');
    }

    public function testResourceWithExpiredLockIsAccessible()
    {
        $acquirer = $this->getMockAcquirer();

        $lock = $this->getMockExpiringLock();
        $lock
            ->expects($this->once())
            ->method('getExpiresAt')
            ->will($this->returnValue(new \DateTime('-1 hour')))
        ;

        $repository = $this->getMockRepository();
        $repository
            ->expects($this->once())
            ->method('release')
            ->with($lock)
        ;

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(true))
        ;
        $resource
            ->expects($this->once())
            ->method('getLock')
            ->will($this->returnValue($lock))
        ;

        $manager = new LockManager($repository);

        $this->assertTrue($manager->isAccessible($acquirer, $resource),
            'A Resource with an expired Lock is accessible.');
    }

    public function testResourceWithValidExpiringLockIsNotAccessible()
    {
        $acquirer = $this->getMockAcquirer();
        $acquirer
            ->expects($this->once())
            ->method('getIdentifier')
            ->will($this->returnValue('MockAcquirer'))
        ;

        $requester = $this->getMockAcquirer();
        $requester
            ->expects($this->once())
            ->method('getIdentifier')
            ->will($this->returnValue('RequestingAcquirer'))
        ;

        $lock = $this->getMockExpiringLock();
        $lock
            ->expects($this->once())
            ->method('getAcquirer')
            ->will($this->returnValue($acquirer))
        ;
        $lock
            ->expects($this->once())
            ->method('getExpiresAt')
            ->will($this->returnValue(new \DateTime('+1 hour')))
        ;

        $repository = $this->getMockRepository();
        $repository
            ->expects($this->never())
            ->method('release')
        ;

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(true))
        ;
        $resource
            ->expects($this->once())
            ->method('getLock')
            ->will($this->returnValue($lock))
        ;

        $manager = new LockManager($repository);

        $this->assertFalse($manager->isAccessible($requester, $resource),
            'A locked Resource is not accessible by other Acquirers.');
    }

    /**
     * @depends testLockedResourceIsAccessibleByAcquirer
     * @depends testLockedResourceIsNotAccessibleByOthers
     */
    public function testInaccessibleResourceCannotBeLocked()
    {
        $acquirer = $this->getMockAcquirer();
        $acquirer
            ->expects($this->atLeastOnce())
            ->method('getIdentifier')
            ->will($this->returnValue('MockAcquirer'))
        ;

        $requester = $this->getMockAcquirer();
        $requester
            ->expects($this->once())
            ->method('getIdentifier')
            ->will($this->returnValue('RequestingAcquirer'))
        ;

        $lock = $this->getMockLock();
        $lock
            ->expects($this->atLeastOnce())
            ->method('getAcquirer')
            ->will($this->returnValue($acquirer))
        ;

        $repository = $this->getMockRepository();

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(true))
        ;
        $resource
            ->expects($this->atLeastOnce())
            ->method('getLock')
            ->will($this->returnValue($lock))
        ;

        $manager = new LockManager($repository);

        $this->setExpectedException('Havvg\Component\Lock\Exception\ResourceLockedException');

        $manager->acquire($requester, $resource);
    }

    /**
     * @depends testLockedResourceIsAccessibleByAcquirer
     * @depends testLockedResourceIsNotAccessibleByOthers
     */
    public function testAcquireAndReleaseLock()
    {
        $acquirer = $this->getMockAcquirer();

        $lock = $this->getMockLock();

        $resource = $this->getMockResource();
        $resource
            ->expects($this->once())
            ->method('isLocked')
            ->will($this->returnValue(false))
        ;

        $repository = $this->getMockRepository();
        $repository
            ->expects($this->once())
            ->method('acquire')
            ->with($acquirer, $resource)
            ->will($this->returnValue($lock))
        ;
        $repository
            ->expects($this->once())
            ->method('release')
            ->with($lock)
            ->will($this->returnValue(true))
        ;

        $manager = new LockManager($repository);

        $this->assertSame($lock, $manager->acquire($acquirer, $resource),
            'The LockManager delegates the creation of the Lock to the Repository.');
        $this->assertTrue($manager->release($lock),
            'The LockManager delegates the release of a Lock to the Respository.');
    }
}
