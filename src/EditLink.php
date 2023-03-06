<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class EditLink
{
    protected object $link;
    protected LinkData $linkData;

    public function __construct(LinkData $linkData, object $link)
    {
        $this->linkData = $linkData;
        $this->link = $link;
    }

    /**
     * Edit Link.
     * @return mixed
     * @throws UniException
     */
    public function edit()
    {
        $optionsAreCorrect = (new CheckLinkOptions($this->link))->check();
        if (!$optionsAreCorrect) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->incorrect(null, 'Link Options')
                ->context($this->link, 'link')->b()
                ->fill();
        }

        return $this->linkData->updateById($this->link->id, $this->link);
    }
}