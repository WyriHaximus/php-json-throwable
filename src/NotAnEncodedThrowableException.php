<?php

namespace WyriHaximus;

use Exception;

final class NotAnEncodedThrowableException extends Exception
{
    public function __construct($json, $field)
    {
        parent::__construct('"' . json_encode($json) . '" is not an encoded Throwable or Exception, field "' . $field . '" is missing');
    }
}
