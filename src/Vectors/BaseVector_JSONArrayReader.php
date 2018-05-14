<?php
declare(strict_types=1);

namespace Strict\SafeJSONReader\Vectors;

use Strict\Collection\Vector\VectorAbstract;
use Strict\SafeJSONReader\JSONArrayReader;


/**
 * [Abstract Class] Base Class of Vector for JSONArrayReader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018. All Rights Reserved.
 * @package strictphp/collection
 * @since v1.0.0
 */
abstract class BaseVector_JSONArrayReader
    extends VectorAbstract
{
    /**
     * Vector_JSONArrayReader constructor.
     *
     * @param JSONArrayReader[] ...$initializer
     */
    public function __construct(JSONArrayReader ...$initializer)
    {
        parent::__construct($initializer);
    }

    /**
     * @return VectorIterator_JSONArrayReader
     *
     * @deprecated
     * @internal
     */
    public function getIterator(): VectorIterator_JSONArrayReader
    {
        return new VectorIterator_JSONArrayReader(...$this->getVector());
    }

    /**
     * @param int $offset
     * @return bool
     *
     * @deprecated
     * @internal
     */
    public function offsetExists($offset): bool
    {
        return $this->argOffsetExists($offset);
    }

    /**
     * @param int $offset
     * @return JSONArrayReader
     *
     * @deprecated
     * @internal
     */
    public function offsetGet($offset): JSONArrayReader
    {
        return $this->argOffsetGet($offset);
    }

    /**
     * @param int|null $offset
     * @param JSONArrayReader $value
     *
     * @deprecated
     * @internal
     */
    public function offsetSet($offset, $value): void
    {
        $this->strictOffsetSet($offset, $value);
    }

    /**
     * Add language-based type validation for offsetSet().
     *
     * @param int|null $offset
     * @param JSONArrayReader $value
     *
     * @internal
     */
    private function strictOffsetSet(?int $offset, JSONArrayReader $value): void
    {
        $this->argOffsetSet($offset, $value);
    }

    /**
     * @param int $offset
     *
     * @deprecated
     * @internal
     */
    public function offsetUnset($offset): void
    {
        $this->argOffsetUnset($offset);
    }
}