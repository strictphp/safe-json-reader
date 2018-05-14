<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;
use Strict\SafeJSONReader\JSONArrayReader;


class ZZZObjectReaderArrayTest
    extends TestCase
{
    use ZZZObjectReaderTrait;

    public function testNull(): void
    {
        $this->assertNull($this->r->getArray('nonexistent'));
    }

    public function testInt(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getArray('int');
    }

    public function testFloat(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getArray('float');
    }

    public function testString(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getArray('string');
    }

    public function testBool(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getArray('true');
    }

    public function testArray(): void
    {
        $this->assertInstanceOf(JSONArrayReader::class, $this->r->getArray('array'));
        $this->assertEquals(["this", "is", 4, "pen"], $this->r->getArray('array')->getRawData());
    }

    public function testObject(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getArray('object');
    }

    public function testRequire(): void
    {
        $this->assertInstanceOf(JSONArrayReader::class, $this->r->requireArray('array'));

        $this->expectNotFound();
        $this->r->requireArray('nonexistent');
    }
}