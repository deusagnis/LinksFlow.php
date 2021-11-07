<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Entities\Link;

class CheckLinkOptions
{
    protected object $link;

    public function __construct(object $link)
    {
        $this->link = $link;
    }

    public function check(): bool
    {
        return $this->expiredDateCorrect()
            and $this->correctRegardingRedirectType();
    }

    protected function expiredDateCorrect(): bool
    {
        return $this->link->expired_at == Link::UNLIMITED_EXPIRED_VALUE
            or $this->link->expired_at > $this->link->created_at;
    }

    protected function correctRegardingRedirectType(): bool
    {
        if ($this->link->redirect_type == Link::SERVER_REDIRECT_TYPE) {
            return $this->withServerRedirectOptionsCorrect();
        }

        return true;
    }

    protected function withServerRedirectOptionsCorrect(): bool
    {
        return empty($this->link->password);
    }
}