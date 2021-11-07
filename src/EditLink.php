<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Exceptions\IncorrectLinkOptions;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class EditLink
{
    protected object $link;
    protected LinkData $linkData;

    public function __construct(LinkData $linkData,object $link)
    {
        $this->linkData = $linkData;
        $this->link = $link;
    }

    public function edit(){
        $optionsAreCorrect = (new CheckLinkOptions($this->link))->check();
        if(!$optionsAreCorrect){
            throw new IncorrectLinkOptions();
        }

        return $this->linkData->updateById($this->link->id,$this->link);
    }
}