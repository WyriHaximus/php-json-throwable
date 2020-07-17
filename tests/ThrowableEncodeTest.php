<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

use function get_class;

final class ThrowableEncodeTest extends TestCase
{
    public function test(): void
    {
        $exception     = new Exception('whoops');
        $json          = [
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'previous' => null,
        ];
        $json['trace'] = [];
        foreach ($exception->getTrace() as $item) {
            $item['args']    = [];
            $json['trace'][] = $item;
        }

        $exception = WyriHaximus\throwable_encode($exception);
        self::assertSame($json, $exception);
    }
}
