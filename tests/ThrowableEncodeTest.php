<?php

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

final class ThrowableEncodeTest extends TestCase
{
    public function test()
    {
        $exception = new Exception('whoops');
        $json = [
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'previous' => $exception->getPrevious(),
        ];
        $json['trace'] = [];
        foreach ($exception->getTrace() as $item) {
            $item['args'] = [];
            $json['trace'][] = $item;
        }

        $exception = WyriHaximus\throwable_encode($exception);
        self::assertSame($json, $exception);
    }
}
