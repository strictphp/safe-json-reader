<?php
declare(strict_types=1);

namespace Strict\SafeJSONReader\Vectors;

use Strict\Collection\Vector\VectorIteratorAbstract;
use Strict\SafeJSONReader\JSONObjectReader;


/**
 * [Class] Vector Iterator for JSONObjectReader
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018. All Rights Reserved.
 * @package strictphp/collection
 * @since v1.0.0
 *
 * @internal
 */
class VectorIterator_JSONObjectReader
    extends VectorIteratorAbstract
{
    public function __construct(JSONObjectReader ...$initializer)
    {
        parent::__construct($initializer);
    }

    public function current(): JSONObjectReader
    {
        return parent::current();
    }
}