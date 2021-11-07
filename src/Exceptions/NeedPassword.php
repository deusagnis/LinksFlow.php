<?php

namespace MGGFLOW\LinksFlow\Exceptions;

class NeedPassword extends \Exception
{
    protected $message = 'Need Password.';
    protected $code = 1;
}