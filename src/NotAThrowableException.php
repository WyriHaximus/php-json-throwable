<?php

namespace WyriHaximus;

use Exception;

final class NotAThrowableException extends Exception
{
    public function __construct($throwable)
    {
        parent::__construct($throwable . ' is not a Throwable or Exception');
    }
}
