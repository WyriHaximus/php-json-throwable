<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use WyriHaximus\ExposeTraceTrait;

final class ExposeTraceException extends Exception
{
    use ExposeTraceTrait;
}
