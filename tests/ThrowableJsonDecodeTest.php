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
            'class' => ExposeTraceException::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'originalTrace' => [['key' => 'value']],
            'previous' => null,
        ]);

        $exception = WyriHaximus\throwable_json_decode($json);
        assert($exception instanceof ExposeTraceException);
        self::assertSame(13, $exception->getCode());
        self::assertSame(__FILE__, $exception->getFile());
        self::assertSame(0, $exception->getLine());
        self::assertNull($exception->getPrevious());
        self::assertSame([['key' => 'value']], $exception->getOriginalTrace());
        self::assertSame('whoops', $exception->getMessage());
    }
}
