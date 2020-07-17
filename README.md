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
* Any previous `Throwable`s will also be encoded and decoded but always with `throwable_json_*`.

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
