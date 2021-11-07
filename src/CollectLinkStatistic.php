<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Entities\LinkStatistic;
use MGGFLOW\LinksFlow\Exceptions\FailedToSaveStatistic;
use MGGFLOW\LinksFlow\Interfaces\LinkStatisticData;

class CollectLinkStatistic
{
    protected object $link;
    protected string $transitIp;
    protected LinkStatisticData $statisticData;

    protected object $linkStatistic;

    public function __construct(LinkStatisticData $statisticData, object $link, string $transitIp)
    {
        $this->statisticData = $statisticData;

        $this->link = $link;
        $this->transitIp = $transitIp;
    }

    public function collect()
    {
        $this->loadStatistic();
        if (empty($this->linkStatistic)) {
            $this->provideStatisticBlank();
        }

        $this->writeStatistic();

        return $this->saveStatistic();
    }

    protected function loadStatistic()
    {
        $this->linkStatistic = $this->statisticData->getByIpAndLinkId($this->link->id, $this->transitIp);
    }

    protected function provideStatisticBlank()
    {
        $this->linkStatistic = LinkStatistic::createStatisticBlank();
        $this->linkStatistic->linkId = $this->link->id;
        $this->linkStatistic->ip = $this->transitIp;
    }

    protected function writeStatistic()
    {
        $this->linkStatistic->transitions++;
        $this->linkStatistic->last_transition_at = time();
    }

    protected function saveStatistic()
    {
        $result = $this->statisticData->saveStatistic($this->linkStatistic);

        if (empty($result)) {
            throw new FailedToSaveStatistic();
        }

        return $result;
    }
}