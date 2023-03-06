<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;

class LinkStatisticOwnership
{
    static protected object $linkStatistic;
    static protected int $userId;

    /**
     * Throw error if User by id does not own the LinkStatistic.
     * @param object $linkStatistic
     * @param int $userId
     * @return void
     * @throws UniException
     */
    static public function check(object $linkStatistic, int $userId)
    {
        static::$linkStatistic = $linkStatistic;
        static::$userId = $userId;

        if (static::notInOwnership()) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->denied('Access')
                ->context($linkStatistic, 'linkStatistic')
                ->context($userId, 'userId')->b()
                ->fill();
        }

    }

    static protected function notInOwnership(): bool
    {
        return static::$linkStatistic->owner_id != static::$userId;
    }
}