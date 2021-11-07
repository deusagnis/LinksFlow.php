<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Exceptions\LinkNotFound;
use MGGFLOW\LinksFlow\Exceptions\NeedPassword;
use MGGFLOW\LinksFlow\Exceptions\PasswordIncorrect;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class LinkTransit
{
    protected string $linkAlias;
    protected string $linkPassword;
    protected LinkData $linkData;
    protected object $link;

    public function __construct(LinkData $linkData, string $linkAlias, string $linkPassword = '')
    {
        $this->linkData = $linkData;


        $this->linkAlias = $linkAlias;
        $this->linkPassword = $linkPassword;
    }

    public function transit()
    {
        $this->loadLink();
        if (empty($this->link)) {
            throw new LinkNotFound();
        }

        $this->checkConditions();

        $this->providePassword();

        $this->incTransitions();

        $this->linkData->updateById($this->link->id, $this->link);

        return $this->link->aim_url;
    }

    protected function loadLink()
    {
        $this->link = $this->linkData->getByAlias($this->linkAlias);
    }

    protected function checkConditions()
    {
        $checkLink = new CheckLinkConditions($this->link);
        $checkLink->check();
    }

    protected function providePassword()
    {
        if ($this->needPassword()) {
            if ($this->noPassword()) {
                throw new NeedPassword();
            }
            if ($this->passwordIncorrect()) {
                throw new PasswordIncorrect();
            }
        }
    }

    protected function needPassword(): bool
    {
        return !empty($this->link->password);
    }

    protected function noPassword(): bool
    {
        return empty($this->linkPassword);
    }

    protected function passwordIncorrect(): bool
    {
        return $this->link->password != $this->linkPassword;
    }

    protected function incTransitions()
    {
        $this->link->transitions++;
    }

    public function needCollectStatistic(): bool
    {
        return (bool)$this->link->need_statistic;
    }
}