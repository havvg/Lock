<?php

namespace Havvg\Component\Lock;

use Havvg\Component\Lock\Acquirer\AcquirerInterface;
use Havvg\Component\Lock\Exception\ResourceLockedException;
use Havvg\Component\Lock\Lock\LockInterface;
use Havvg\Component\Lock\Repository\RepositoryInterface;
use Havvg\Component\Lock\Resource\ResourceInterface;

/**
 * The LockManager is a convenient way to interact with the Lock component.
 */
class LockManager
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Check whether the given Acquirer may access the Resource in question.
     *
     * @param AcquirerInterface $acquirer
     * @param ResourceInterface $resource
     *
     * @return bool
     */
    public function isAccessible(AcquirerInterface $acquirer, ResourceInterface $resource)
    {
        if (!$resource->isLocked()) {
            return true;
        }

        return $resource->getLock()->getAcquirer()->getIdentifier() === $acquirer->getIdentifier();
    }

    /**
     * Try to acquire a Lock on the given Resource.
     *
     * @param AcquirerInterface $acquirer
     * @param ResourceInterface $resource
     *
     * @return LockInterface
     *
     * @throws ResourceLockedException
     */
    public function acquire(AcquirerInterface $acquirer, ResourceInterface $resource)
    {
        if (!$this->isAccessible($acquirer, $resource)) {
            throw new ResourceLockedException(sprintf('The resource is not accessible. It is locked by "%s".', $resource->getLock()->getAcquirer()->getIdentifier()));
        }

        return $this->repository->acquire($acquirer, $resource);
    }

    /**
     * Release the given Lock freeing its Resource to be accessed.
     *
     * @param LockInterface $lock
     *
     * @return bool
     */
    public function release(LockInterface $lock)
    {
        return $this->repository->release($lock);
    }
}
