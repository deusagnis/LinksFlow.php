<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class LinkTransit
{
    protected string $linkAlias;
    protected string $linkPassword;
    protected LinkData $linkData;
    public ?object $link;

    public function __construct(LinkData $linkData, string $linkAlias, string $linkPassword = '')
    {
        $this->linkData = $linkData;


        $this->linkAlias = $linkAlias;
        $this->linkPassword = $linkPassword;
    }

    /**
     * Provide Link transition.
     * @return mixed
     * @throws UniException
     */
    public function transit()
    {
        $this->loadLink();
        if (empty($this->link)) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->not('Link')->found()
                ->context($this->linkAlias, 'linkAlias')
                ->context($this->linkPassword, 'linkPassword')->b()
                ->fill();
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
                throw ManageException::build()
                    ->log()->info()->b()
                    ->desc()->need(null, 'Password')
                    ->context($this->link, 'link')->b()
                    ->fill();
            }
            if ($this->passwordIncorrect()) {
                throw ManageException::build()
                    ->log()->info()->b()
                    ->desc()->wrong(null, 'Password')
                    ->context($this->link, 'link')->b()
                    ->fill();
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