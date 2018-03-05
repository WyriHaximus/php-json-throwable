<?php

namespace WyriHaximus\Tests;

use Exception;

class RequiredConstructorArgumentsException extends Exception
{
    public function __construct($required, $alsoRequired, $anotherRequiredArgument)
    {
        // void
    }
}
