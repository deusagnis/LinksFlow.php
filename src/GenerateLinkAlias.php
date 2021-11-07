<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\LinksFlow\Exceptions\FailedToComeUpWithAlias;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class GenerateLinkAlias
{
    public int $length = 6;
    public int $attempts = 3;
    public string $availableChars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    protected LinkData $linkData;

    public function __construct(LinkData $linkData)
    {
        $this->linkData = $linkData;
    }

    public function generate(): string
    {
        $attempts = 0;

        while ($attempts < $this->attempts) {
            $alias = $this->genRandomString();
            if (!$this->linkData->existsByAlias($alias)) {
                return $alias;
            }
            $attempts++;
        }

        throw new FailedToComeUpWithAlias();
    }

    protected function genRandomString(): string
    {
        $string = '';

        for ($i = 0; $i < $this->length; $i++) {
            $string .= $this->availableChars[mt_rand(0, strlen($this->availableChars) - 1)];
        }

        return $string;
    }
}