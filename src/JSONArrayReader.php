<?php declare(strict_types=1);

namespace Strict\SafeJSONReader;

use ArrayIterator;
use IteratorAggregate;
use stdClass;
use Strict\Collection\Vector\Scalar\Vector_bool;
use Strict\Collection\Vector\Scalar\Vector_float;
use Strict\Collection\Vector\Scalar\Vector_int;
use Strict\Collection\Vector\Scalar\Vector_string;
use Strict\SafeJSONReader\Exceptions\UnexpectedFieldTypeException;
use Strict\SafeJSONReader\Vectors\Vector_JSONArrayReader;
use Strict\SafeJSONReader\Vectors\Vector_JSONObjectReader;
use Traversable;


/**
 * [Class] JSON Array Reader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 StrictPHP. All Rights Reserved.
 * @package srictphp/safe-json-reader
 * @since v1.0.0
 */
class JSONArrayReader
    implements IteratorAggregate
{
    private $data;
    private $previous;

    /**
     * JSONArrayReader constructor.
     *
     * @param array $parsedJSON
     * @param string $previousKey
     */
    public function __construct(array $parsedJSON, string $previousKey = 'array')
    {
        $this->data = $parsedJSON;
        $this->previous = $previousKey;
    }

    /**
     * Return raw parsedJSON in array.
     *
     * @return array
     */
    final public function getRawData(): array
    {
        return $this->data;
    }

    /**
     * Treat this array as an array of strings and return it.
     * Throw an exception if a value which is not compatible with string found in this array.
     *
     * @return Vector_string
     */
    final public function asStringArray(): Vector_string
    {
        $stack = [];
        foreach ($this->data as $key => $value) {
            if (is_object($value) || is_array($value) || is_null($value)) throw UnexpectedFieldTypeException::FromArray(
                'string', $value, $this->getAccessor($key), $this->previous
            );

            if (is_bool($value)) {
                $stack[] = $value ? 'true' : 'false';
            } else {
                $stack[] = (string)$value;
            }
        }
        return new Vector_string(...$stack);
    }

    /**
     * Treat this array as an array of integers and return it.
     * Throw an exception if a value which is not compatible with int found in this array.
     *
     * @return Vector_int
     */
    final public function asIntArray(): Vector_int
    {
        $stack = [];
        foreach ($this->data as $key => $value) {
            if (is_int($value)) {
                $stack[] = $value;
                continue;
            } else if (is_string($value) && is_numeric($value)) {
                $fromString = (int)$value;
                if ($value === (string)$fromString) {
                    $stack[] = $fromString;
                    continue;
                }
            }
            throw UnexpectedFieldTypeException::FromArray('int', $value, $this->getAccessor($key), $this->previous);
        }
        return new Vector_int(...$stack);
    }

    /**
     * Treat this array as an array of floats and return it.
     * Throw an exception if a value which is not compatible with float found in this array.
     *
     * @return Vector_float
     */
    final public function asFloatArray(): Vector_float
    {
        $stack = [];
        foreach ($this->data as $key => $value) {
            if (is_float($value) || is_int($value) || (is_string($value) && is_numeric($value))) {
                $stack[] = (float)$value;
            } else {
                throw UnexpectedFieldTypeException::FromArray('float', $value, $this->getAccessor($key), $this->previous);
            }
        }
        return new Vector_float(...$stack);
    }

    /**
     * Treat this array as an array of booleans and return it.
     * Throw an exception if a value which is not compatible with bool found in this array.
     *
     * @return Vector_bool
     */
    final public function asBoolArray(): Vector_bool
    {
        $stack = [];
        $trueCan = [1, 'true', 'on', true, 'yes'];
        $falseCan = [0, 'false', 'off', false, 'no'];
        foreach ($this->data as $key => $value) {
            if (is_string($value)) $value = strtolower($value);
            if (false !== array_search($value, $trueCan, true)) {
                $stack[] = true;
            } else if (false !== array_search($value, $falseCan, true)) {
                $stack[] = false;
            } else {
                throw UnexpectedFieldTypeException::FromArray('bool', $value, $this->getAccessor($key), $this->previous);
            }
        }
        return new Vector_bool(...$stack);
    }

    /**
     * Treat this array as an array of objects and return it.
     * Throw an exception if a value which is not compatible with object found in this array.
     *
     * @return Vector_JSONObjectReader
     */
    final public function asObjectArray(): Vector_JSONObjectReader
    {
        $stack = [];
        foreach ($this->data as $key => $value) {
            if ($value instanceof stdClass) {
                $stack[] = new JSONObjectReader($value, $this->getAccessor($key));
            } else if (is_object($value)) {
                throw UnexpectedFieldTypeException::FromClass($value, $this->getAccessor($key));
            } else {
                throw UnexpectedFieldTypeException::FromArray('object', $value, $this->getAccessor($key), $this->previous);
            }
        }
        return new Vector_JSONObjectReader(...$stack);
    }

    /**
     * Treat this array as an array of arrays and return it.
     * Throw an exception if a value which is not compatible with array found in this array.
     *
     * @return Vector_JSONArrayReader
     */
    final public function asArrayArray(): Vector_JSONArrayReader
    {
        $stack = [];
        foreach ($this->data as $key => $value) {
            if (is_array($value)) {
                $stack[] = new JSONArrayReader($value, $this->getAccessor($key));
            } else {
                throw UnexpectedFieldTypeException::FromArray('array', $value, $this->getAccessor($key), $this->previous);
            }
        }
        return new Vector_JSONArrayReader(...$stack);
    }

    /**
     * Return an iterator of this array.
     *
     * @return Traversable
     *
     * @internal
     * @deprecated
     */
    public function getIterator(): Traversable
    {
        $stack = [];
        foreach ($this->data as $key => $value) {
            if (is_array($value)) {
                $stack[] = new JSONArrayReader($value, $this->getAccessor($key));
            } else if ($value instanceof stdClass) {
                $stack[] = new JSONObjectReader($value, $this->getAccessor($key));
            } else {
                $stack[] = $value;
            }
        }
        return new ArrayIterator($stack);
    }

    private function getAccessor(int $key): string
    {
        return $this->previous . "[{$key}]";
    }
}