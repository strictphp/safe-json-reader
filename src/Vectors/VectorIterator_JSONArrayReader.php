<?php
declare(strict_types=1);

namespace Strict\SafeJSONReader\Vectors;

use Strict\Collection\Vector\VectorIteratorAbstract;
use Strict\SafeJSONReader\JSONArrayReader;


/**
 * [Class] Vector Iterator for JSONArrayReader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018. All Rights Reserved.
 * @package strictphp/collection
 * @since v1.0.0
 *
 * @internal
 */
class VectorIterator_JSONArrayReader
    extends VectorIteratorAbstract
{
    public function __construct(JSONArrayReader ...$initializer)
    {
        parent::__construct($initializer);
    }

    public function current(): JSONArrayReader
    {
        return parent::current();
    }
}