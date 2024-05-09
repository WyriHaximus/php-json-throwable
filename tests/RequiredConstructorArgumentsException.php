<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;

// phpcs:disable
/**
 * @phpstan-ignore-next-line
 */
class RequiredConstructorArgumentsException extends Exception
{
    /**
     * @phpstan-ignore-next-line
     */
    public function __construct($required, $alsoRequired, $anotherRequiredArgument)
    {
        // void
    }
}
