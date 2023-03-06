<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;
use MGGFLOW\LinksFlow\Entities\Link;

class CheckLinkConditions
{
    protected object $link;

    public function __construct(object $link)
    {
        $this->link = $link;
    }

    /**
     * Throw Error if Link does not meet the conditions.
     * @return void
     * @throws UniException
     */
    public function check()
    {
        if (!$this->linkFresh()) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->expired('Link')
                ->context($this->link, 'link')->b()
                ->fill();
        }
        if (!$this->transitionsAvailable()) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->tooMany(null, 'Transitions')
                ->context($this->link, 'link')->b()
                ->fill();
        }
    }

    protected function linkFresh(): bool
    {
        return $this->link->expired_at > time();
    }

    protected function transitionsAvailable(): bool
    {
        return $this->link->transition_limit == Link::UNLIMITED_EXPIRED_VALUE
            or $this->link->transitions < $this->link->transition_limit;
    }
}