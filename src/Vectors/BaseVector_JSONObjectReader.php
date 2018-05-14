<?php
declare(strict_types=1);

namespace Strict\SafeJSONReader\Vectors;

use Strict\Collection\Vector\VectorAbstract;
use Strict\SafeJSONReader\JSONObjectReader;


/**
 * [Abstract Class] Base Class of Vector for JSONObjectReader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018. All Rights Reserved.
 * @package strictphp/collection
 * @since v1.0.0
 */
abstract class BaseVector_JSONObjectReader
    extends VectorAbstract
{
    /**
     * Vector_JSONObjectReader constructor.
     *
     * @param JSONObjectReader[] ...$initializer
     */
    public function __construct(JSONObjectReader ...$initializer)
    {
        parent::__construct($initializer);
    }

    /**
     * @return VectorIterator_JSONObjectReader
     *
     * @deprecated
     * @internal
     */
    public function getIterator(): VectorIterator_JSONObjectReader
    {
        return new VectorIterator_JSONObjectReader(...$this->getVector());
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
     * @return JSONObjectReader
     *
     * @deprecated
     * @internal
     */
    public function offsetGet($offset): JSONObjectReader
    {
        return $this->argOffsetGet($offset);
    }

    /**
     * @param int|null $offset
     * @param JSONObjectReader $value
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
     * @param JSONObjectReader $value
     *
     * @internal
     */
    private function strictOffsetSet(?int $offset, JSONObjectReader $value): void
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