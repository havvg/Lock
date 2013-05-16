<?php

namespace Havvg\Component\Lock\Lock;

use Havvg\Component\Lock\Exception\DomainException;

/**
 * This trait implements the ExpiringLockInterface.
 *
 * It allows to extend the expiration datetime.
 */
trait ExpiringLockTrait
{
    /**
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * @var \DateInterval
     */
    protected $ttl;

    public function setTtl(\DateInterval $ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * Extend the expiration datetime by the set TTL.
     *
     * If there is no expiration datetime initialized, it will be.
     *
     * @throws \DomainException If there is no TTL set.
     */
    public function extendExpiration()
    {
        if (null === $this->ttl) {
            throw new DomainException('There is no TTL set for this Lock.');
        }

        if (!$this->expiresAt) {
            $this->expiresAt = new \DateTime();
            $this->expiresAt->setTimestamp(time());
        }

        $this->expiresAt->add($this->ttl);
    }

    /**
     * Return the datetime of expiration for this Lock.
     *
     * @see ExpiringLockInterface::getExpiresAt
     *
     * @return \DateTime
     *
     * @throws \DomainException If no expiration datetime has been initialized.
     */
    public function getExpiresAt()
    {
        if (null === $this->expiresAt) {
            throw new DomainException('There is no expiration date set.');
        }

        return $this->expiresAt;
    }
}
