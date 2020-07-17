<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;

// phpcs:disable
final class FinalRequiredConstructorArgumentsException extends Exception
{
    public function __construct($required, $alsoRequired, $anotherRequiredArgument)
    {
        // void
    }
}
