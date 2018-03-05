<?php

namespace WyriHaximus\Tests;

use Exception;

final class FinalRequiredConstructorArgumentsException extends Exception
{
    public function __construct($required, $alsoRequired, $anotherRequiredArgument)
    {
        // void
    }
}
