<?php

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

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
            'previous' => null,
            'class' => Exception::class,
        ];

        /** @var Exception $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertSame(13, $exception->getCode());
        self::assertSame(__FILE__, $exception->getFile());
        self::assertSame(0, $exception->getLine());
        self::assertSame([], $exception->getTrace());
        self::assertSame('whoops', $exception->getMessage());
    }

    public function testWithMissingAttributes()
    {
        $json = [
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'previous' => null,
            'class' => MissingAttributes::class,
        ];

        /** @var MissingAttributes $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertSame('whoops', $exception->message);
    }

    public function testRequiredConstructorArguments()
    {
        $json = [
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'previous' => null,
            'class' => RequiredConstructorArgumentsException::class,
        ];

        /** @var RequiredConstructorArgumentsException $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf(RequiredConstructorArgumentsException::class, $exception);
        self::assertSame('whoops', $exception->getMessage());
    }

    public function testFinal()
    {
        $json = [
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'previous' => null,
            'class' => FinalException::class,
        ];

        /** @var FinalException $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf(FinalException::class, $exception);
        self::assertSame('whoops', $exception->getMessage());
    }

    public function testFinalRequiredConstructorArguments()
    {
        $json = [
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'previous' => null,
            'class' => FinalRequiredConstructorArgumentsException::class,
        ];

        /** @var FinalRequiredConstructorArgumentsException $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf(FinalRequiredConstructorArgumentsException::class, $exception);
        self::assertSame('whoops', $exception->getMessage());
    }
}
