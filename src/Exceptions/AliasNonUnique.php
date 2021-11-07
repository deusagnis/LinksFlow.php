<?php

namespace MGGFLOW\LinksFlow\Exceptions;

class AliasNonUnique extends \Exception
{
    protected $message = 'The alias is not unique.';
}