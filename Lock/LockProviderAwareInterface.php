<?php

namespace Havvg\Component\Lock\Lock;

interface LockProviderAwareInterface
{
    /**
     * Set or unset the LockProvider in use.
     *
     * @param LockProviderInterface|null $provider
     */
    public function setLockProvider(LockProviderInterface $provider = null);

    /**
     * Return the currently set LockProvider, if any.
     *
     * @return LockProviderInterface|null
     */
    public function getLockProvider();
}
