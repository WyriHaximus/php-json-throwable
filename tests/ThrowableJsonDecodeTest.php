<?php

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

final class ThrowableJsonDecodeTest extends TestCase
{
    public function test()
    {
        $json = json_encode([
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'previous' => null,
            'class' => Exception::class,
        ]);

        /** @var Exception $exception */
        $exception = WyriHaximus\throwable_json_decode($json);
        self::assertSame(13, $exception->getCode());
        self::assertSame(__FILE__, $exception->getFile());
        self::assertSame(0, $exception->getLine());
        self::assertNull($exception->getPrevious());
        self::assertSame([], $exception->getTrace());
        self::assertSame('whoops', $exception->getMessage());
    }
}
