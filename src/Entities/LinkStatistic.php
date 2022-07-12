<?php

namespace MGGFLOW\LinksFlow\Entities;

class LinkStatistic
{
    /**
     * Create object of LinkStatistic with default fields.
     * @return object
     */
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