<?php

declare(strict_types=1);

namespace WyriHaximus;

use Exception;

final class NotAnEncodedThrowableException extends Exception
{
    /** @var array<string, mixed> */
    private array $json;
    private string $field;

    /**
     * @param array<string, mixed> $json
     */
    public function __construct(array $json, string $field)
    {
        parent::__construct('Given array is not an encoded Throwable, at least one field is missing');

        $this->json  = $json;
        $this->field = $field;
    }

    /**
     * @return array<string, mixed>
     */
    public function json(): array
    {
        return $this->json;
    }

    public function field(): string
    {
        return $this->field;
    }
}
