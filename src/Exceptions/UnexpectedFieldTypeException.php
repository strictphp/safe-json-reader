<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Exceptions;

use ReflectionObject;
use RuntimeException;


/**
 * [Exception] Unexpected Field Type
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 StrictPHP. All Rights Reserved.
 * @package srictphp/safe-json-reader
 * @since v1.0.0
 */
class UnexpectedFieldTypeException
    extends RuntimeException
{
    public static function FromClass(object $value, string $accessor): self
    {
        $refObj = new ReflectionObject($value);
        return new self(
            "The field {$accessor} is expected to be an instance of stdClass, an instance of {$refObj->getShortName()} ({$refObj->getName()}) is set"
        );
    }

    public static function FromValue(string $expectedType, $value, string $accessor): self
    {
        $type = gettype($value);
        if($type === 'double') $type = 'float';
        return new self(
            "The field {$accessor} is expected to be of the type {$expectedType}, {$type} is set"
        );
    }

    public static function FromArrayClass(object $value, string $accessor, string $arrayAccessor): self
    {
        $refObj = new ReflectionObject($value);
        return new self(
            "The element of array {$arrayAccessor} is expected to be an instance of stdClass, {$accessor} is an instance of {$refObj->getShortName()} ({$refObj->getName()})"
        );
    }

    public static function FromArray(string $expectedType, $value, string $accessor, string $arrayAccessor): self
    {
        $type = gettype($value);
        if($type === 'double') $type = 'float';
        return new self(
            "The element of array {$arrayAccessor} is expected to be of the type {$expectedType}, the type of {$accessor} is {$type}"
        );
    }
}