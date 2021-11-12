<?php

namespace MGGFLOW\LinksFlow\Policies;

use MGGFLOW\LinksFlow\Exceptions\AccessDenied;

class LinkStatisticOwnership
{
    static protected object $linkStatistic;
    static protected int $userId;

    static public function check(object $linkStatistic, int $userId){
        static::$linkStatistic = $linkStatistic;
        static::$userId = $userId;

        if(static::notInOwnership()){
            throw new AccessDenied();
        }

    }

    static protected function notInOwnership(){
        return static::$linkStatistic->owner_id != static::$userId;
    }
}