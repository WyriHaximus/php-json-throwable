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
            'class' => 'Exception',
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
            'class' => 'WyriHaximus\Tests\MissingAttributes',
        ];

        /** @var MissingAttributes $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertSame('whoops', $exception->message);
        self::assertFalse(isset($exception->code));
    }

    public function testRequiredConstructorArguments()
    {
        $json = [
            'message' => 'whoops',
            'code' => 13,
            'file' => __FILE__,
            'line' => 0,
            'trace' => [],
            'class' => 'WyriHaximus\Tests\RequiredConstructorArgumentsException',
        ];

        /** @var RequiredConstructorArgumentsException $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf('WyriHaximus\Tests\RequiredConstructorArgumentsException', $exception);
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
            'class' => 'WyriHaximus\Tests\FinalException',
        ];

        /** @var FinalException $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf('WyriHaximus\Tests\FinalException', $exception);
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
            'class' => 'WyriHaximus\Tests\FinalRequiredConstructorArgumentsException',
        ];

        /** @var FinalRequiredConstructorArgumentsException $exception */
        $exception = WyriHaximus\throwable_decode($json);
        self::assertInstanceOf('WyriHaximus\Tests\FinalRequiredConstructorArgumentsException', $exception);
        self::assertSame('whoops', $exception->getMessage());
    }
}
