<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use PHPUnit\Framework\TestCase;
use WyriHaximus;

use function assert;
use function Safe\json_encode;

final class ThrowableJsonDecodeTest extends TestCase
{
    public function test(): void
    {
        $json = json_encode([
            'class' => FinalException::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'previous' => null,
        ]);

        $exception = WyriHaximus\throwable_json_decode($json);
        assert($exception instanceof FinalException);
        self::assertSame(13, $exception->getCode());
        self::assertSame(__FILE__, $exception->getFile());
        self::assertSame(0, $exception->getLine());
        self::assertNull($exception->getPrevious());
//        self::assertSame([], $exception->getTrace());
        self::assertSame('whoops', $exception->getMessage());
    }
}
