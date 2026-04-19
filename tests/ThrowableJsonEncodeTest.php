<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use WyriHaximus;

use function json_encode;
use function json_last_error_msg;

final class ThrowableJsonEncodeTest extends TestCase
{
    #[Test]
    public function bare(): void
    {
        $exception = new Exception('whoops');
        $array     = [
            'class' => $exception::class,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'previous' => $exception->getPrevious(),
            'originalTrace' => [],
            'additionalProperties' => [],
        ];
        foreach ($exception->getTrace() as $item) {
            $item['args']             = [];
            $array['originalTrace'][] = $item;
        }

        $json = json_encode($array);
        self::assertIsString($json, json_last_error_msg());

        $exceptionJson = WyriHaximus\throwable_json_encode($exception);
        self::assertJsonStringEqualsJsonString($json, $exceptionJson);
    }
}
