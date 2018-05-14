<?php declare(strict_types=1);

namespace Strict\SafeJSONReader;


/**
 * [Class] JSON Array Reader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 StrictPHP. All Rights Reserved.
 * @package srictphp/safe-json-reader
 * @since v1.0.0
 */
class JSONArrayReader
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
}