<?php declare(strict_types=1);

namespace Strict\SafeJSONReader;

use stdClass;
use Strict\SafeJSONReader\Exceptions\FieldNotFoundException;
use Strict\SafeJSONReader\Exceptions\UnexpectedFieldTypeException;


/**
 * [Class] JSON Object Reader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 StrictPHP. All Rights Reserved.
 * @package srictphp/safe-json-reader
 * @since v1.0.0
 */
class JSONObjectReader
{
    private $data;
    private $previous;

    /**
     * JSONObjectReader constructor.
     *
     * @param stdClass $parsedJSON
     * @param string $previousKey like 'data.container'
     */
    public function __construct(stdClass $parsedJSON, string $previousKey = 'object')
    {
        $this->data = $parsedJSON;
        $this->previous = $previousKey . '.';
    }

    /**
     * Return raw parsedJSON in stdClass.
     *
     * @return stdClass
     */
    final public function getRawData(): stdClass
    {
        return $this->data;
    }

    /**
     * Return null if field does not exist.
     * Return int if the value of the field is int or convertible to int.
     * Throw an exception if the value of the field is not compatible with int.
     *
     * @param string[] ...$keys
     * @return int|null
     */
    final public function getInt(string ...$keys): ?int
    {
        $value = $this->get(...$keys);

        if (is_int($value)) return $value;
        if (is_null($value)) return null;
        if (is_string($value) && is_numeric($value)) {
            $fromString = (int)$value;
            if ($value === (string)$fromString) {
                return $fromString;
            }
        }

        throw UnexpectedFieldTypeException::FromValue('int', $value, $this->getAccessor(...$keys));
    }

    /**
     * Call getInt() and throw an exception if the return value of getInt() is null.
     *
     * @param string[] ...$keys
     * @return int
     */
    final public function requireInt(string ...$keys): int
    {
        $value = $this->getInt(...$keys);

        if (is_null($value)) throw FieldNotFoundException::FromAccessor($this->getAccessor(...$keys));

        return $value;
    }

    /**
     * Return null if field does not exist.
     * Return string if the value of the field is string or convertible to string.
     * Throw an exception if the value of the field is not compatible with string.
     *
     * @param string[] ...$keys
     * @return null|string
     */
    final public function getString(string ...$keys): ?string
    {
        $value = $this->get(...$keys);

        if (is_object($value) || is_array($value)) throw UnexpectedFieldTypeException::FromValue(
            'string', $value, $this->getAccessor(...$keys)
        );

        if (is_null($value)) return null;
        if (is_bool($value)) return $value ? 'true' : 'false';
        return (string)$value;
    }

    /**
     * Call getString() and throw an exception if the return value of getString() is null.
     *
     * @param string[] ...$keys
     * @return string
     */
    final public function requireString(string ...$keys): string
    {
        $value = $this->getString(...$keys);

        if (is_null($value)) throw FieldNotFoundException::FromAccessor($this->getAccessor(...$keys));

        return $value;
    }

    /**
     * Return null if field does not exist.
     * Return float if the value of the field is float or convertible to float.
     * Throw an exception if the value of the field is not compatible with float.
     *
     * @param string[] ...$keys
     * @return float|null
     */
    final public function getFloat(string ...$keys): ?float
    {
        $value = $this->get(...$keys);

        if (is_float($value) || is_int($value)) return (float)$value;
        if (is_null($value)) return null;
        if (is_string($value) && is_numeric($value)) return (float)$value;

        throw UnexpectedFieldTypeException::FromValue('float', $value, $this->getAccessor(...$keys));
    }

    /**
     * Call getFloat() and throw an exception if the return value of getFloat() is null.
     *
     * @param string[] ...$keys
     * @return float
     */
    final public function requireFloat(string ...$keys): float
    {
        $value = $this->getFloat(...$keys);

        if (is_null($value)) throw FieldNotFoundException::FromAccessor($this->getAccessor(...$keys));

        return $value;
    }

    /**
     * Return null if field does not exist.
     * Return bool if the value of the field is bool or convertible to bool.
     * Throw an exception if the value of the field is not compatible with bool.
     *
     * @param string[] ...$keys
     * @return bool|null
     */
    final public function getBool(string ...$keys): ?bool
    {
        $value = $this->get(...$keys);
        if (is_string($value)) $value = strtolower($value);

        if (false !== array_search($value, [1, 'true', 'on', true, 'yes'], true)) return true;
        if (false !== array_search($value, [0, 'false', 'off', false, 'no'], true)) return false;

        if (is_null($value)) return null;

        throw UnexpectedFieldTypeException::FromValue('bool', $value, $this->getAccessor(...$keys));
    }

    /**
     * Call getBool() and throw an exception if the return value of getBool() is null.
     *
     * @param string[] ...$keys
     * @return bool
     */
    final public function requireBool(string ...$keys): bool
    {
        $value = $this->getBool(...$keys);

        if (is_null($value)) throw FieldNotFoundException::FromAccessor($this->getAccessor(...$keys));

        return $value;
    }

    /**
     * Return null if field does not exist.
     * Return JSONObjectReader if the value of the field is object or convertible to object.
     * Throw an exception if the value of the field is not compatible with object.
     *
     * @param string[] ...$keys
     * @return null|JSONObjectReader
     */
    final public function getObject(string ...$keys): ?JSONObjectReader
    {
        $value = $this->get(...$keys);

        if ($value instanceof stdClass) return new JSONObjectReader($value, $this->getAccessor(...$keys));
        if (is_null($value)) return null;

        if (is_object($value)) {
            throw UnexpectedFieldTypeException::FromClass($value, $this->getAccessor(...$keys));
        } else {
            throw UnexpectedFieldTypeException::FromValue('object', $value, $this->getAccessor(...$keys));
        }
    }

    /**
     * Call getObject() and throw an exception if the return value of getObject() is null.
     *
     * @param string[] ...$keys
     * @return JSONObjectReader
     */
    final public function requireObject(string ...$keys): JSONObjectReader
    {
        $value = $this->getObject(...$keys);

        if (is_null($value)) throw FieldNotFoundException::FromAccessor($this->getAccessor(...$keys));

        return $value;
    }

    /**
     * Return null if field does not exist.
     * Return JSONArrayReader if the value of the field is array or convertible to array.
     * Throw an exception if the value of the field is not compatible with array.
     *
     *
     * @param string[] ...$keys
     * @return null|JSONArrayReader
     */
    final public function getArray(string ...$keys): ?JSONArrayReader
    {
        $value = $this->get(...$keys);

        if (is_array($value)) return new JSONArrayReader($value, $this->getAccessor(...$keys));
        if (is_null($value)) return null;

        throw UnexpectedFieldTypeException::FromValue('array', $value, $this->getAccessor(...$keys));
    }

    /**
     * Call getArray() and throw an exception if the return value of getArray() is null.
     *
     * @param string[] ...$keys
     * @return JSONArrayReader
     */
    final public function requireArray(string ...$keys): JSONArrayReader
    {
        $value = $this->getArray(...$keys);

        if (is_null($value)) throw FieldNotFoundException::FromAccessor($this->getAccessor(...$keys));

        return $value;
    }

    /**
     * Acquire field.
     * Return null if field does not exist.
     *
     * @param string[] ...$keys
     * @return mixed
     */
    private function get(string ...$keys)
    {
        $current = $this->data;
        foreach ($keys as $key) {
            if (!isset($current->{$key})) {
                return null;
            }
            $current = $current->{$key};
        }
        return $current;
    }

    /**
     * @param string[] ...$keys
     * @return string
     */
    private function getAccessor(string ...$keys): string
    {
        return $this->previous . implode('.', $keys);
    }
}