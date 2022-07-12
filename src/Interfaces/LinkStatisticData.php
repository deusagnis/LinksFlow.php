<?php

namespace MGGFLOW\LinksFlow\Interfaces;

interface LinkStatisticData
{
    /**
     * Get LinkStatistic by IP and Link id.
     * @param int $linkId
     * @param string $ip
     * @return mixed
     */
    public function getByIpAndLinkId(int $linkId, string $ip);

    /**
     * Create or update LinkStatistic.
     * @param object $statistic
     * @return mixed
     */
    public function saveStatistic(object $statistic);

    /**
     * Remove LinkStatistic by Link id.
     * @param int $linkId
     * @return mixed
     */
    public function removeByLinkId(int $linkId);
}