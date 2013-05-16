<?php

namespace Havvg\Component\Lock\Tests\Lock;

use Havvg\Component\Lock\Lock\ExpiringLockTrait;
use Havvg\Component\Lock\Tests\AbstractTest;

/**
 * @covers Havvg\Component\Lock\Lock\ExpiringLockTrait
 */
class ExpiringLockTraitTest extends AbstractTest
{
    public static function setUpBeforeClass()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            static::markTestSkipped();
        }
    }

    public function testTtlIsRequiredBeforeExtending()
    {
        $expiringLock = $this->getExpiringLock();

        $this->setExpectedException('Havvg\Component\Lock\Exception\DomainException');

        $expiringLock->extendExpiration();
    }

    public function testInitialExpirationDateIsRequired()
    {
        $expiringLock = $this->getExpiringLock();

        $this->setExpectedException('Havvg\Component\Lock\Exception\DomainException');

        $expiringLock->getExpiresAt();
    }

    public function testExpirationDateIsCreatedIfNoneGiven()
    {
        $expiringLock = $this->getExpiringLock();
        $expiringLock->setTtl(new \DateInterval('PT3600S')); // 1 hour (3600s)

        $expiringLock->extendExpiration();

        $this->assertInstanceOf('\DateTime', $expiringLock->getExpiresAt());
        $this->assertGreaterThan(new \DateTime(), $expiringLock->getExpiresAt());
    }

    public function testExpirationIsExtendedByTTL()
    {
        $ttl = new \DateInterval('PT3600S');

        $expiringLock = $this->getExpiringLock();
        $expiringLock->setTtl($ttl);

        $expiringLock->extendExpiration();

        $date = clone $expiringLock->getExpiresAt();
        $date->add($ttl);

        $expiringLock->extendExpiration();

        $this->assertEquals($date, $expiringLock->getExpiresAt());
    }

    /**
     * @return ExpiringLockTrait
     */
    protected function getExpiringLock()
    {
        return $this->getObjectForTrait('Havvg\Component\Lock\Lock\ExpiringLockTrait');
    }
}
