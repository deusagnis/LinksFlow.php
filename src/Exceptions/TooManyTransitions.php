<?php

namespace MGGFLOW\LinksFlow\Exceptions;

class TooManyTransitions extends \Exception
{
    protected $message = 'Too many transitions.';
}