<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;
use Strict\SafeJSONReader\JSONObjectReader;


class ZZZObjectReaderObjectTest
    extends TestCase
{
    use ZZZObjectReaderTrait;

    public function testNull(): void
    {
        $this->assertNull($this->r->getObject('nonexistent'));
    }

    public function testInt(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getObject('int');
    }

    public function testFloat(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getObject('float');
    }

    public function testString(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getObject('string');
    }

    public function testBool(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getObject('true');
    }

    public function testArray(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getObject('array');
    }

    public function testObject(): void
    {
        $this->assertInstanceOf(JSONObjectReader::class, $this->r->getObject('object'));
        $this->assertEquals(334, $this->r->getObject('object')->getInt('int'));
    }

    public function testRequire(): void
    {
        $this->assertInstanceOf(JSONObjectReader::class, $this->r->requireObject('object'));

        $this->expectNotFound();
        $this->r->requireObject('nonexistent');
    }
}