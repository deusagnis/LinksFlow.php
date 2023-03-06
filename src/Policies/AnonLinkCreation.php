<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;
use MGGFLOW\LinksFlow\Entities\Link;

/**
 * Restrictions on Link creation for unregistered user.
 */
class AnonLinkCreation
{
    /**
     * Max transition limit.
     */
    const MAX_TRANSITION_LIMIT = 5000;
    /**
     * Collecting statistic is unavailable.
     */
    const NEED_STATISTIC = false;
    /**
     * Max Link duration.
     */
    const MAX_DURATION = 30 * 24 * 60 * 60;

    static protected object $link;

    /**
     * Throw error if Link have fields prohibited for unregistered user.
     * @param $link
     * @return void
     * @throws UniException
     */
    static public function check($link)
    {
        static::$link = $link;

        if (static::statisticsNeedMismatch()
            or static::soBigTransitionLimit()
            or static::soBigDuration()
            or static::usingServerRedirect()
        ) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->incorrect(null, 'Link Configuration')
                ->context($link, 'link')->b()
                ->fill();
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