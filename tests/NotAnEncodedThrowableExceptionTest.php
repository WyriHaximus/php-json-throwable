<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use PHPUnit\Framework\TestCase;
use WyriHaximus\NotAnEncodedThrowableException;

final class NotAnEncodedThrowableExceptionTest extends TestCase
{
    public function test(): void
    {
        $json      = ['string' => 'array', 'null' => null, 'integer' => 123];
        $exception = new NotAnEncodedThrowableException($json, 'array');

        self::assertSame('Given array is not an encoded Throwable, at least one field is missing', $exception->getMessage());
        self::assertSame($json, $exception->json());
        self::assertSame('array', $exception->field());
    }
}
