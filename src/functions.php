<?php

namespace WyriHaximus;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Throwable;

function throwable_json_encode($throwable)
{
    return json_encode(throwable_encode($throwable));
}

function throwable_encode($throwable)
{
    if (!($throwable instanceof Exception) && !($throwable instanceof Throwable)) {
        throw new NotAThrowableException($throwable);
    }

    $json = [];
    $json['class'] = get_class($throwable);
    $json['message'] = $throwable->getMessage();
    $json['code'] = $throwable->getCode();
    $json['file'] = $throwable->getFile();
    $json['line'] = $throwable->getLine();
    $json['trace'] = [];
    foreach ($throwable->getTrace() as $item) {
        $item['args'] = [];
        $json['trace'][] = $item;
    }

    return $json;
}

function throwable_json_decode($json)
{
    return throwable_decode(json_decode($json, true));
}

function throwable_decode($json)
{
    $properties = [
        'message',
        'code',
        'file',
        'line',
        'trace',
        'class',
    ];

    foreach ($properties as $property) {
        if (!isset($json[$property])) {
            throw new NotAnEncodedThrowableException($json);
        }
    }

    array_pop($properties);

    if (PHP_MAJOR_VERSION === 7) {
        $throwable = (new ReflectionClass($json['class']))->newInstanceWithoutConstructor();
    }
    $class = new ReflectionClass($json['class']);
    if (!isset($throwable)) {
        $throwable = new $json['class']();
    }
    foreach ($properties as $key) {
        if (!$class->hasProperty($key)) {
            continue;
        }

        $property = new ReflectionProperty($json['class'], $key);
        $property->setAccessible(true);
        $property->setValue($throwable, $json[$key]);
    }

    return $throwable;
}
