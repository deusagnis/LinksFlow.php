<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Interfaces\LinkData;
use MGGFLOW\LinksFlow\Interfaces\LinkStatisticData;

class RemoveLink
{
    protected int $linkId;
    protected LinkData $linkData;
    protected LinkStatisticData $linkStatisticData;

    public function __construct(LinkData $linkData, LinkStatisticData $linkStatisticData, int $linkId)
    {
        $this->linkData = $linkData;
        $this->linkStatisticData = $linkStatisticData;
        $this->linkId = $linkId;
    }

    /**
     * Remove Link.
     * @return void
     */
    public function remove()
    {
        $this->removeLink();
        $this->removeStatistic();
    }

    protected function removeLink()
    {
        $this->linkData->removeById($this->linkId);
    }

    protected function removeStatistic()
    {
        $this->linkStatisticData->removeByLinkId($this->linkId);
    }
}