<?php

namespace Havvg\Component\Lock\Repository;

use Havvg\Component\Lock\Acquirer\AcquirerInterface;
use Havvg\Component\Lock\Exception\ResourceLockedException;
use Havvg\Component\Lock\Exception\UnsupportedException;
use Havvg\Component\Lock\Lock\LockInterface;
use Havvg\Component\Lock\Resource\ResourceInterface;

/**
 * The Repository reflects the current state on Locks.
 *
 * It knows about who acquired a Lock on which Resource.
 * Releasing a Lock may result in removing the knowledge on Resource and Acquirer, if no other Lock is related to either.
 *
 * This Repository is not meant to know about every possible Acquirer and Resource at a given time.
 * An implementation may support the information, but it's not required.
 */
interface RepositoryInterface
{
    /**
     * Try to acquire a Lock on the given Resource.
     *
     * @param AcquirerInterface $acquirer
     * @param ResourceInterface $resource
     *
     * @return LockInterface
     *
     * @throws ResourceLockedException
     * @throws UnsupportedException
     */
    public function acquire(AcquirerInterface $acquirer, ResourceInterface $resource);

    /**
     * Release the given Lock freeing its Resource to be accessed.
     *
     * @param LockInterface $lock
     *
     * @return bool
     */
    public function release(LockInterface $lock);

    /**
     * Return the list of Locks being held.
     *
     * @return LockInterface[]|\Traversable
     */
    public function getLocks();

    /**
     * Return the list of locked Resources.
     *
     * @return ResourceInterface[]|\Traversable
     */
    public function getResources();

    /**
     * Check whether this Repository contains the given Resource.
     *
     * @param ResourceInterface $resource
     *
     * @return bool
     */
    public function hasResource(ResourceInterface $resource);

    /**
     * Return the list of known Acquirers.
     *
     * @return AcquirerInterface[]|\Traversable
     */
    public function getAcquirers();
}
