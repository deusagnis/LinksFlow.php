<?php

namespace MGGFLOW\LinksFlow;

use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;
use MGGFLOW\LinksFlow\Interfaces\LinkData;

class GenerateLinkAlias
{
    /**
     * Length of Alias.
     * @var int
     */
    public int $length = 6;
    /**
     * Tries to generate unique Alias.
     * @var int
     */
    public int $attempts = 3;
    /**
     * Alphabet of Alias.
     * @var string
     */
    public string $availableChars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    protected LinkData $linkData;

    public function __construct(LinkData $linkData)
    {
        $this->linkData = $linkData;
    }

    /**
     * Generate random Alias.
     * @return string
     * @throws UniException
     */
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

        throw ManageException::build()
            ->log()->info()->b()
            ->desc()->failed(null, 'to Generate Unique Alias')->b()
            ->fill();
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