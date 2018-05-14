<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Exceptions;

use RuntimeException;


/**
 * [Exception] Field Not Found
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 StrictPHP. All Rights Reserved.
 * @package srictphp/safe-json-reader
 * @since v1.0.0
 */
class FieldNotFoundException
    extends RuntimeException
{
    public static function FromAccessor(string $accessor): self
    {
        return new self(
            "The field {$accessor} is expected to exist, not found"
        );
    }
}