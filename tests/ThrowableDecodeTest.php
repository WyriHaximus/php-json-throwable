<?php

namespace WyriHaximus\Tests;

use PHPUnit\Framework\TestCase;
use function WyriHaximus\throwable_decode;

final class ThrowableDecodeTest extends TestCase
{
    public function test()
    {
        $json = [
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'class' => '\Exception',
        ];

        /** @var \Exception $exception */
        $exception = throwable_decode($json);
        self::assertSame(13, $exception->getCode());
        self::assertSame(__FILE__, $exception->getFile());
        self::assertSame(0, $exception->getLine());
        self::assertSame([], $exception->getTrace());
        self::assertSame('whoops', $exception->getMessage());
    }
}
