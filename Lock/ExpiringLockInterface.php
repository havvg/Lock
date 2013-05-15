<?php

namespace Havvg\Component\Lock\Lock;

/**
 * An ExpiringLock is a simple way to avoid endless locks, in case the Lock has not be released e.g. due to errors.
 */
interface ExpiringLockInterface extends LockInterface
{
    /**
     * Return the datetime of expiration for this Lock.
     *
     * If the Lock is still present after the expiration datetime, it is meant to be ignored and removed.
     * When acquiring a Lock on a Resource locked by an expired Lock, the Resource is accessible.
     *
     * @return \DateTime
     */
    public function getExpiresAt();
}
