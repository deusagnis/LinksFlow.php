<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\LinksFlow\Exceptions\AccessDenied;

class LinkOwnership
{
    static protected object $link;
    static protected int $userId;

    /**
     * Throw error if User by id does not own the Link.
     * @param object $link
     * @param int $userId
     * @return void
     * @throws AccessDenied
     */
    static public function check(object $link, int $userId){
        static::$link = $link;
        static::$userId = $userId;

        if(static::notInOwnership()){
            throw new AccessDenied();
        }

    }

    static protected function notInOwnership(){
        return static::$link->owner_id != static::$userId;
    }
}