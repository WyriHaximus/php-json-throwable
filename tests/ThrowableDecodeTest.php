<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use PHPUnit\Framework\TestCase;
use WyriHaximus;

use function assert;
use function serialize;
use function time;

final class ThrowableDecodeTest extends TestCase
{
    public function test(): void
    {
        $json = [
            'class' => ExposeTraceException::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'originalTrace' => [['key' => 'value']],
            'previous' => null,
            'additionalProperties' => [],
        ];

        $exception = WyriHaximus\throwable_decode($json);
        assert($exception instanceof ExposeTraceException);
        self::assertSame(13, $exception->getCode());
        self::assertSame(__FILE__, $exception->getFile());
        self::assertSame(0, $exception->getLine());
        self::assertSame([['key' => 'value']], $exception->getOriginalTrace());
        self::assertSame('whoops', $exception->getMessage());
    }

    public function testWithMissingAttributes(): void
    {
        $json = [
            'class' => MissingAttributes::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'originalTrace' => [],
            'previous' => null,
            'additionalProperties' => [],
        ];

        $exception = WyriHaximus\throwable_decode($json);
        assert($exception instanceof MissingAttributes);
        self::assertSame('whoops', $exception->message);
    }

    public function testRequiredConstructorArguments(): void
    {
        $json = [
            'class' => RequiredConstructorArgumentsException::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'originalTrace' => [],
            'previous' => null,
            'additionalProperties' => [],
        ];

        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf(RequiredConstructorArgumentsException::class, $exception);
        self::assertSame('whoops', $exception->getMessage());
    }

    public function testFinalRequiredConstructorArguments(): void
    {
        $json = [
            'class' => FinalRequiredConstructorArgumentsException::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'originalTrace' => [],
            'previous' => null,
            'additionalProperties' => [],
        ];

        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf(FinalRequiredConstructorArgumentsException::class, $exception);
        self::assertSame('whoops', $exception->getMessage());
    }

    /**
     * @test
     */
    public function additionalProperties(): void
    {
        $time = time();
        $json = [
            'class' => AdditionalPropertiesException::class,
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'originalTrace' => [],
            'previous' => null,
            'additionalProperties' => ['time' => serialize($time)],
        ];

        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf(AdditionalPropertiesException::class, $exception);
        self::assertSame($time, $exception->time());
    }
}
