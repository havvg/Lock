<?php

namespace Havvg\Component\Lock\Lock;

use Havvg\Component\Lock\Acquirer\AcquirerInterface;
use Havvg\Component\Lock\Resource\ResourceInterface;

interface LockInterface
{
    /**
     * Return the locked Resource.
     *
     * @return ResourceInterface
     */
    public function getResource();

    /**
     * Return the Acquirer of this Lock.
     *
     * @return AcquirerInterface
     */
    public function getAcquirer();
}
