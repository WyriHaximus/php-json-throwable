<?php

declare(strict_types=1);

namespace WyriHaximus;

use Doctrine\Instantiator\Exception\ExceptionInterface;
use Doctrine\Instantiator\Instantiator;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Throwable;

use function array_pop;
use function assert;
use function get_class;
use function Safe\json_decode;
use function Safe\json_encode;

function throwable_json_encode(Throwable $throwable): string
{
    return json_encode(throwable_encode($throwable));
}

/**
 * @return array{class: class-string<Throwable>, code: mixed, file: string, line: int, message: string, previous: string|null, trace: array<int, mixed>}
 */
function throwable_encode(Throwable $throwable): array
{
    $json            = [];
    $json['class']   = get_class($throwable);
    $json['message'] = $throwable->getMessage();
    $json['code']    = $throwable->getCode();
    $json['file']    = $throwable->getFile();
    $json['line']    = $throwable->getLine();
    /** @psalm-suppress PossiblyNullArgument */
    $json['previous'] = $throwable->getPrevious() instanceof Throwable ? throwable_json_encode($throwable->getPrevious()) : null;

    $json['trace'] = [];
    foreach ($throwable->getTrace() as $item) {
        $item['args']    = [];
        $json['trace'][] = $item;
    }

    return $json;
}

function throwable_json_decode(string $json): Throwable
{
    return throwable_decode(json_decode($json, true));
}

/**
 * @param array{class: class-string<Throwable>, message: string, code: mixed, file: string, line: int, previous: string|null, trace: array<int, mixed>} $json
 *
 * @throws ExceptionInterface
 * @throws ReflectionException
 */
function throwable_decode(array $json): Throwable
{
    $properties = [
        'class' => 'string',
        'message' => 'string',
        'code' => 'integer',
        'file' => 'string',
        'line' => 'integer',
        'previous' => ['string', 'NULL'],
        'trace' => 'array',
    ];

    validate_array($json, $properties, NotAnEncodedThrowableException::class);

    array_pop($properties);

    if ($json['previous'] !== null) {
        $json['previous'] = throwable_json_decode($json['previous']);
    }

    $throwable = (new Instantiator())->instantiate($json['class']);
    assert($throwable instanceof Throwable);
    $class = new ReflectionClass($json['class']);
    foreach ($properties as $key => $type) {
        if (! $class->hasProperty($key)) {
            continue;
        }

        $property = new ReflectionProperty($json['class'], $key);
        $property->setAccessible(true);
        $property->setValue($throwable, $json[$key]);
        $property->setAccessible(false);
    }

    return $throwable;
}
