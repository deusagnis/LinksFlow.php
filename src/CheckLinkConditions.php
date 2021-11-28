<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Entities\Link;
use MGGFLOW\LinksFlow\Exceptions\LinkExpired;
use MGGFLOW\LinksFlow\Exceptions\TooManyTransitions;

class CheckLinkConditions
{
    protected object $link;

    public function __construct(object $link)
    {
        $this->link = $link;
    }

    public function check()
    {
        if (!$this->linkFresh()) {
            throw new LinkExpired();
        }
        if (!$this->transitionsAvailable()) {
            throw new TooManyTransitions();
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