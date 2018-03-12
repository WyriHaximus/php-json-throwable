<?php

namespace WyriHaximus;

use Doctrine\Instantiator\Instantiator;
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
    $json['previous'] = $throwable->getPrevious();
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
        'previous',
        'trace',
        'class',
    ];

    foreach ($properties as $property) {
        if (!isset($json[$property]) && !array_key_exists($property, $json)) {
            throw new NotAnEncodedThrowableException($json);
        }
    }

    array_pop($properties);

    $throwable = (new Instantiator())->instantiate($json['class']);
    $class = new ReflectionClass($json['class']);
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
