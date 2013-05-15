<?php

namespace Havvg\Component\Lock\Resource;

use Havvg\Component\Lock\Lock\LockInterface;

/**
 * A Resource reflects anything being accessed by someone or somewhat.
 *
 * Examples:
 *
 *   It may be some symbolic lock to avoid running the same scheduled command twice at a given time if the command runs longer than it's recurring schedule.
 *
 *   A Resource may be an entity in your data storage e.g. a customer in your CRM, who is contacted by one of your staff.
 *   Note: Please do not confuse the Lock acquired by this component with the database locking mechanism!
 */
interface ResourceInterface
{
    /**
     * Check whether this resource is locked.
     *
     * @return bool
     */
    public function isLocked();

    /**
     * Return the Lock for this resource.
     *
     * If this Resource is not locked, null is returned.
     *
     * @return LockInterface|null
     */
    public function getLock();

    /**
     * Check whether it is mandatory to retrieve a Lock before operating on this Resource.
     *
     * If a Lock is mandatory, an Acquirer is required to create a Lock prior accessing the Resource.
     * This cannot be enforced programmatically, it's part of the contract between all Acquirers.
     *
     * @return bool
     */
    public function isLockMandatory();
}
