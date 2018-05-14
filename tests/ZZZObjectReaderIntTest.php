<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;
use Strict\SafeJSONReader\Exceptions\FieldNotFoundException;
use Strict\SafeJSONReader\Exceptions\UnexpectedFieldTypeException;


class ZZZObjectReaderIntTest
    extends TestCase
{
    use ZZZObjectReaderTrait;

    public function testNull(): void
    {
        $r = $this->r;
        $this->assertNull($r->getInt('nonexistent'));
    }

    public function testInt(): void
    {
        $r = $this->r;
        $this->assertEquals(334, $r->getInt('int'));
    }

    public function testFloat(): void
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getInt('float');
    }

    public function testString(): void
    {
        $r = $this->r;
        $this->assertEquals(334, $r->getInt('stringLikeInt'));

        $this->expectUnexpectedFieldType();
        $r->getInt('string');
    }

    public function testBool(): void
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getInt('true');
    }

    public function testArray(): void
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getInt('array');
    }

    public function testObject(): void
    {
        $r = $this->r;
        $this->expectUnexpectedFieldType();
        $r->getInt('object');
    }

    public function testRequire()
    {
        $r = $this->r;
        $this->assertEquals(334, $r->requireInt('int'));

        $this->expectNotFound();
        $r->requireInt('nonexistent');
    }
}