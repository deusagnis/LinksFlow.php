<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\LinksFlow\Entities\Link;
use MGGFLOW\LinksFlow\Exceptions\UnavailableConfiguration;

class AnonLinkCreation
{
    const MAX_TRANSITION_LIMIT = 5000;
    const NEED_STATISTIC = false;
    const MAX_DURATION = 30 * 24 * 60 * 60;

    static protected object $link;

    static public function check($link)
    {
        static::$link = $link;

        if (static::statisticsNeedMismatch()
            or static::soBigTransitionLimit()
            or static::soBigDuration()
            or static::usingServerRedirect()
        ) {
            throw new UnavailableConfiguration();
        }
    }

    static protected function statisticsNeedMismatch(): bool
    {
        return static::$link->need_statistic != static::NEED_STATISTIC;
    }

    static protected function soBigTransitionLimit(): bool
    {
        return static::MAX_TRANSITION_LIMIT != 0 and static::$link->transition_limit > static::MAX_TRANSITION_LIMIT;
    }

    static protected function soBigDuration(): bool
    {
        return static::MAX_DURATION != 0 and static::$link->expired_at > time() + static::MAX_DURATION;
    }

    static protected function usingServerRedirect(): bool
    {
        return static::$link->redirect_type == Link::SERVER_REDIRECT_TYPE;
    }
}