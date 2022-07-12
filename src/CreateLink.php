<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Exceptions\AliasNonUnique;
use MGGFLOW\LinksFlow\Exceptions\IncorrectLinkOptions;
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
     * @throws AliasNonUnique
     * @throws IncorrectLinkOptions
     */
    public function create()
    {
        $optionsAreCorrect = (new CheckLinkOptions($this->link))->check();
        if (!$optionsAreCorrect) {
            throw new IncorrectLinkOptions();
        }

        if ($this->needGenerateAlias()) {
            $this->generateAlias();
        } elseif ($this->linkData->existsByAlias($this->link->alias)) {
            throw new AliasNonUnique();
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