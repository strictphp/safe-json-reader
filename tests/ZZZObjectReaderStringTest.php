<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;
use Strict\SafeJSONReader\Exceptions\FieldNotFoundException;
use Strict\SafeJSONReader\Exceptions\UnexpectedFieldTypeException;


class ZZZObjectReaderStringTest
    extends TestCase
{
    use ZZZObjectReaderTrait;

    public function testNull()
    {
        $r = $this->r;
        $this->assertNull($r->getString('nonexistent'));
    }

    public function testInt()
    {
        $r = $this->r;
        $this->assertEquals('334', $r->getString('int'));
    }

    public function testFloat()
    {
        $r = $this->r;
        $this->assertEquals('3.34', $r->getString('float'));
    }

    public function testString()
    {
        $r = $this->r;
        $this->assertEquals('string', $r->getString('string'));
    }

    public function testBool()
    {
        $r = $this->r;
        $this->assertEquals('true', $r->getString('true'));
        $this->assertEquals('false', $r->getString('false'));
    }

    public function testArray()
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getString('array');
    }

    public function testObject()
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getString('object');
    }

    public function testRequire()
    {
        $r = $this->r;
        $this->assertEquals('string', $r->requireString('string'));

        $this->expectNotFound();
        $r->requireString('nonexistent');
    }
}