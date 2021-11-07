<?php

namespace MGGFLOW\LinksFlow\Entities;

class LinkStatistic
{
    public static function createStatisticBlank(): object
    {
        $now = time();
        return (object)[
            'transitions' => 0,
            'first_transition_at' => $now,
            'last_transition_at' => $now,
        ];
    }
}