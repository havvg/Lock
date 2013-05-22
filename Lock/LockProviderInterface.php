<?php

namespace Havvg\Component\Lock\Lock;

use Havvg\Component\Lock\Acquirer\AcquirerInterface;
use Havvg\Component\Lock\Exception\UnsupportedException;
use Havvg\Component\Lock\Resource\ResourceInterface;

interface LockProviderInterface
{
    /**
     * Create a new Lock for the given acquirer and resource.
     *
     * The Lock is created, is does not verify its validity!
     *
     * @param AcquirerInterface $acquirer
     * @param ResourceInterface $resource
     *
     * @return LockInterface
     *
     * @throws UnsupportedException
     */
    public function create(AcquirerInterface $acquirer, ResourceInterface $resource);
}
