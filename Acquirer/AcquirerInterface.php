<?php

namespace Havvg\Component\Lock\Acquirer;

interface AcquirerInterface
{
    /**
     * Return an identifier for this Acquirer.
     *
     * The returned value is meant to be unique among *all* Acquirer.
     *
     * If the Acquirer is a certain command (e.g. running as a Cronjob) each process returns a different identifier.
     * This would allow to verify the Lock is acquired by the current process, not the current command, which may have crashed and therefore may not have released the Lock.
     *
     * In case the Acquirer reflects a human being, e.g. a logged in user, it may be valid to return the same identifier within the same session.
     *
     * @return string
     */
    public function getIdentifier();
}
