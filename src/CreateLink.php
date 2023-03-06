<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class CreateLink
{
    protected object $link;
    protected LinkData $linkData;

    public function __construct(LinkData $linkData, object $link)
    {
        $this->linkData = $linkData;
        $this->link = $link;

        $this->link->created_at = time();
    }

    /**
     * Create Link.
     * @return mixed
     * @throws UniException
     */
    public function create()
    {
        $optionsAreCorrect = (new CheckLinkOptions($this->link))->check();
        if (!$optionsAreCorrect) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->incorrect(null, 'Link Options')
                ->context($this->link, 'link')->b()
                ->fill();
        }

        if ($this->needGenerateAlias()) {
            $this->generateAlias();
        } elseif ($this->linkData->existsByAlias($this->link->alias)) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->already('Link Alias')->exists()
                ->context($this->link, 'link')->b()
                ->fill();
        }

        return $this->linkData->createLink($this->link);
    }

    protected function needGenerateAlias(): bool
    {
        return empty($this->link->alias);
    }

    protected function generateAlias()
    {
        $aliasGenerator = new GenerateLinkAlias($this->linkData);

        $this->link->alias = $aliasGenerator->generate();
    }
}