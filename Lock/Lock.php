<?php

namespace Havvg\Component\Lock\Lock;

use Havvg\Component\Lock\Acquirer\AcquirerInterface;
use Havvg\Component\Lock\Resource\ResourceInterface;

class Lock implements LockInterface
{
    protected $acquirer;
    protected $resource;

    public function __construct(AcquirerInterface $acquirer, ResourceInterface $resource)
    {
        $this->acquirer = $acquirer;
        $this->resource = $resource;
    }

    /**
     * Return the locked Resource.
     *
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Return the Acquirer of this Lock.
     *
     * @return AcquirerInterface
     */
    public function getAcquirer()
    {
        return $this->acquirer;
    }
}
