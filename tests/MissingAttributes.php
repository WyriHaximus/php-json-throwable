<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;

// phpcs:disable
final class MissingAttributes extends Exception
{
    public $message;
}
