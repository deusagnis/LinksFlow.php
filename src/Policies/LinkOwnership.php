<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;

class LinkOwnership
{
    static protected object $link;
    static protected int $userId;

    /**
     * Throw error if User by id does not own the Link.
     * @param object $link
     * @param int $userId
     * @return void
     * @throws UniException
     */
    static public function check(object $link, int $userId)
    {
        static::$link = $link;
        static::$userId = $userId;

        if (static::notInOwnership()) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->denied('Access')
                ->context($link, 'link')
                ->context($userId, 'userId')->b()
                ->fill();
        }

    }

    static protected function notInOwnership(): bool
    {
        return static::$link->owner_id != static::$userId;
    }
}