# JSON encode and decode throwables and exceptions

![Continuous Integration](https://github.com/wyrihaximus/php-json-throwable/workflows/Continuous%20Integration/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/wyrihaximus/json-throwable/v/stable.png)](https://packagist.org/packages/wyrihaximus/json-throwable)
[![Total Downloads](https://poser.pugx.org/wyrihaximus/json-throwable/downloads.png)](https://packagist.org/packages/wyrihaximus/json-throwable/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/php-json-throwable/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/php-json-throwable/?branch=master)
[![Type Coverage](https://shepherd.dev/github/WyriHaximus/php-json-throwable/coverage.svg)](https://shepherd.dev/github/WyriHaximus/php-json-throwable)
[![License](https://poser.pugx.org/wyrihaximus/json-throwable/license.png)](https://packagist.org/packages/wyrihaximus/json-throwable)

### Installation

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `~`.

```
composer require wyrihaximus/json-throwable
```

### Usage

This package comes with four functions:

* `throwable_json_encode` - Encodes any Throwable to a JSON string
* `throwable_encode` - Encodes any Throwable to an array
* `throwable_json_decode` - Decodes a JSON string in the format from `throwable_json_encode` into the original `Exception` or `Error`
* `throwable_decode` - Decodes an array in the format from `throwable_encode` into the original `Exception` or `Error`

#### Heads up

There are a few gotchas when using this package.

* Both the encoding functions drop the arguments from the trace.
* Because we can't overwrite the trace, a new one will be placed in the `originalTrace` property when available.
* Any previous `Throwable`s will also be encoded and decoded but always with `throwable_json_*`.

Example of gaining access to the original trace, it isn't optimal, but it works:

```php
<?php

declare(strict_types=1);

final class ExposeTraceException extends Exception
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
```

Alternatively you can use the trait supplied by this package:

```php
<?php

declare(strict_types=1);

use WyriHaximus\ExposeTraceTrait;

final class ExposeTraceException extends Exception
{
    use ExposeTraceTrait;
}
```

## Including additional properties from throwables

If your throwables include any properties you'd want to take along when it gets encoded, implement the `AdditionalPropertiesInterface` returning a list of all properties you'd want to haved included in the encoding:

```php
<?php

declare(strict_types=1);

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

```

## Encode/Decode array type hint

When you're calling `throwable_encode` or `throwable_decode` the array (return) type hint has the following signature:

```php
array{class: class-string<Throwable>, message: string, code: mixed, file: string, line: int, previous: string|null, originalTrace: array<int, mixed>, additionalProperties: array<string, string>}
```

This signature isn't enforce by PHP but tools like [`PHPStan`](https://phpstan.org/) or [`Psalm`](https://psalm.dev/) will use it  to assert type safety from a static analysis pont of view.

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2020 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
