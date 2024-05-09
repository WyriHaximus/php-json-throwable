<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use WyriHaximus\AdditionalPropertiesInterface;
use WyriHaximus\ExposeTraceTrait;

final class AdditionalPropertiesException extends Exception implements AdditionalPropertiesInterface
{
    use ExposeTraceTrait;

    public function __construct(private int $time)
    {
        parent::__construct('Additional properties exception raised');
    }

    public function time(): int
    {
        return $this->time;
    }

    /** @return array<string> */
    public function additionalProperties(): array
    {
        return ['time'];
    }
}
