<?php

declare(strict_types=1);

namespace WyriHaximus\React;

use function function_exists;

if (! function_exists('WyriHaximus\throwable_encode')) {
    require __DIR__ . '/functions.php';
}
