<?php

declare(strict_types=1);

namespace WyriHaximus;

use Exception;

final class NotAnEncodedThrowableException extends Exception
{
    /** @param array<string, mixed> $json */
    public function __construct(private array $json, private string $field)
    {
        parent::__construct('Given array is not an encoded Throwable, at least one field is missing');
    }

    /** @return array<string, mixed> */
    public function json(): array
    {
        return $this->json;
    }

    public function field(): string
    {
        return $this->field;
    }
}
