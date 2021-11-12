<?php

namespace MGGFLOW\LinksFlow\Interfaces;

interface LinkStatisticData
{
    public function getByIpAndLinkId(int $linkId, string $ip);

    public function saveStatistic(object $statistic);

    public function removeByLinkId(int $linkId);
}