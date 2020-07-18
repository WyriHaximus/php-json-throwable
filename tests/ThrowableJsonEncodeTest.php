<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

use function get_class;
use function Safe\json_encode;

final class ThrowableJsonEncodeTest extends TestCase
{
    public function test(): void
    {
        $exception = new Exception('whoops');
        $json      = [
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'previous' => $exception->getPrevious(),
            'originalTrace' => [],
            'additionalProperties' => [],
        ];
        foreach ($exception->getTrace() as $item) {
            $item['args']            = [];
            $json['originalTrace'][] = $item;
        }

        $json = json_encode($json);

        $exception = WyriHaximus\throwable_json_encode($exception);
        self::assertSame($json, $exception);
    }
}
