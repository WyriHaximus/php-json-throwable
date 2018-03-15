<?php

namespace WyriHaximus;

use Doctrine\Instantiator\Instantiator;
use Exception;
use ReflectionClass;
use ReflectionProperty;
use Throwable;

/**
 * @throws NotAThrowableException
 */
function throwable_json_encode(Throwable $throwable): string
{
    return json_encode(throwable_encode($throwable));
}

/**
 * @throws NotAThrowableException
 */
function throwable_encode(Throwable $throwable): array
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

function throwable_json_decode(string $json): Throwable
{
    return throwable_decode(json_decode($json, true));
}

function throwable_decode(array $json): Throwable
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

    validate_array($json, $properties, NotAnEncodedThrowableException::class);

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
