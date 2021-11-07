<?php

namespace MGGFLOW\LinksFlow\Interfaces;

interface LinkStatisticData
{
    public function getByIpAndLinkId(int $linkId, string $ip);

    public function saveStatistic(object $statistic);

    public function removeByLinkId(int $linkId);

    public function findByLinkId(int $linkId, int $count, int $offset);
}