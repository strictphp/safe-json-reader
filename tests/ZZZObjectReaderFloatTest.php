<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;


class ZZZObjectReaderFloatTest
    extends TestCase
{
    use ZZZObjectReaderTrait;

    public function testNull()
    {
        $r = $this->r;
        $this->assertNull($r->getFloat('nonexistent'));
    }

    public function testInt()
    {
        $r = $this->r;
        $this->assertEquals(334, $r->getFloat('int'));
    }

    public function testFloat()
    {
        $r = $this->r;
        $this->assertEquals(3.34, $r->getFloat('float'));
    }

    public function testString()
    {
        $r = $this->r;
        $this->assertEquals(3.34, $r->getFloat('stringLikeFloat'));

        $this->expectUnexpectedFieldType();
        $r->getFloat('string');
    }

    public function testBool()
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getFloat('object', 'true');
    }

    public function testArray()
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getFloat('array');
    }

    public function testObject()
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getFloat('object');
    }

    public function testRequire()
    {
        $r = $this->r;
        $this->assertEquals(3.34, $r->requireFloat('float'));

        $this->expectNotFound();
        $r->requireFloat('nonexistent');
    }
}