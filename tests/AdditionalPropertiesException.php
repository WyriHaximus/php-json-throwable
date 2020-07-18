<?php

declare(strict_types=1);

namespace WyriHaximus\Tests;

use Exception;
use WyriHaximus\AdditionalPropertiesInterface;
use WyriHaximus\ExposeTraceTrait;

final class AdditionalPropertiesException extends Exception implements AdditionalPropertiesInterface
{
    use ExposeTraceTrait;

    private int $time;

    public function __construct(int $time)
    {
        parent::__construct('Additional properties exception raised');
        $this->time = $time;
    }

    public function time(): int
    {
        return $this->time;
    }

    /**
     * @return array<string>
     */
    public function additionalProperties(): array
    {
        return ['time'];
    }
}
