<?php

declare(strict_types=1);

namespace WyriHaximus;

interface AdditionalPropertiesInterface
{
    /** @return list<string> */
    public function additionalProperties(): array;
}
