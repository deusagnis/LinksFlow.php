<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\LinksFlow\Exceptions\AccessDenied;

class LinkOwnership
{
    static protected object $link;
    static protected int $userId;

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