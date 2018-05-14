<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;


class ZZZObjectReaderBoolTest
    extends TestCase
{
    use ZZZObjectReaderTrait;

    public function testNull(): void
    {
        $this->assertNull($this->r->getBool('nonexistent'));
    }

    public function testInt(): void
    {
        $this->assertTrue($this->r->getBool('trulyInt'));
        $this->assertFalse($this->r->getBool('falsyInt'));

        $this->expectUnexpectedFieldType();
        $this->r->getBool('int');
    }

    public function testFloat(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getBool('float');
    }

    public function testString(): void
    {
        $this->assertTrue($this->r->getBool('trulyString1'));
        $this->assertTrue($this->r->getBool('trulyString2'));
        $this->assertTrue($this->r->getBool('trulyString3'));
        $this->assertFalse($this->r->getBool('falsyString1'));
        $this->assertFalse($this->r->getBool('falsyString1'));
        $this->assertFalse($this->r->getBool('falsyString1'));

        $this->expectUnexpectedFieldType();
        $this->r->getBool('string');
    }

    public function testBool(): void
    {
        $this->assertTrue($this->r->getBool('true'));
        $this->assertFalse($this->r->getBool('false'));
    }

    public function testArray(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getBool('array');
    }

    public function testObject(): void
    {
        $this->expectUnexpectedFieldType();
        $this->r->getBool('object');
    }

    public function testRequire(): void
    {
        $this->assertTrue($this->r->requireBool('true'));

        $this->expectNotFound();
        $this->r->requireBool('nonexistent');
    }
}