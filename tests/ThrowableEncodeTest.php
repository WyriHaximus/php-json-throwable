<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

use function serialize;
use function time;

final class ThrowableEncodeTest extends TestCase
{
    public function test(): void
    {
        $exception = new Exception('whoops');
        $json      = [
            'class' => $exception::class,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'previous' => null,
            'originalTrace' => [],
            'additionalProperties' => [],
        ];
        foreach ($exception->getTrace() as $item) {
            $item['args']            = [];
            $json['originalTrace'][] = $item;
        }

        $exception = WyriHaximus\throwable_encode($exception);
        self::assertSame($json, $exception);
    }

    /** @test */
    public function additionalProperties(): void
    {
        $time      = time();
        $exception = new AdditionalPropertiesException($time);
        $json      = [
            'class' => $exception::class,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'previous' => null,
            'originalTrace' => [],
            'additionalProperties' => ['time' => serialize($time)],
        ];
        foreach ($exception->getTrace() as $item) {
            $item['args']            = [];
            $json['originalTrace'][] = $item;
        }

        $exception = WyriHaximus\throwable_encode($exception);
        self::assertSame($json, $exception);
    }
}
