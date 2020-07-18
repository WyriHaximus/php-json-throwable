<?php

declare(strict_types=1);

namespace WyriHaximus;

trait ExposeTraceTrait
{
    /** @var array<array<string, mixed>> */
    private array $originalTrace = [];

    /**
     * @return array<array<string, mixed>>
     */
    public function getOriginalTrace(): array
    {
        return $this->originalTrace;
    }
}
