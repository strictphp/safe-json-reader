<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use PHPUnit\Framework\TestCase;
use Strict\SafeJSONReader\Exceptions\UnexpectedFieldTypeException;
use Strict\SafeJSONReader\JSONArrayReader;


class ZZZArrayReaderTest
    extends TestCase
{
    private function create(...$values): JSONArrayReader
    {
        return new JSONArrayReader($values);
    }

    private function expectFTE(): void
    {
        $this->expectException(UnexpectedFieldTypeException::class);
    }

    public function testInt()
    {
        foreach ($this->create('334', 334)->asIntArray() as $int) {
            $this->assertEquals(334, $int);
        }

        $this->expectFTE();
        $this->create('string')->asIntArray();
    }

    public function testFloat()
    {
        foreach ($this->create(33.4, '33.4', 334, '334')->asFloatArray() as $float) {
            $this->assertTrue(33.4 === $float || 334.0 === $float);
        }

        $this->expectFTE();
        $this->create('string')->asFloatArray();
    }

    public function testString()
    {
        foreach ($this->create('string')->asStringArray() as $string) {
            $this->assertEquals('string', $string);
        }
        foreach ($this->create(334, 334.0, '334')->asStringArray() as $string) {
            $this->assertEquals('334', $string);
        }
        foreach ($this->create(true)->asStringArray() as $string) {
            $this->assertEquals('true', $string);
        }
        foreach ($this->create(false)->asStringArray() as $string) {
            $this->assertEquals('false', $string);
        }

        $this->expectFTE();
        $this->create([])->asStringArray();
    }

    public function testBool()
    {
        foreach ($this->create(true, 'Yes', 'On', 'True', 1)->asBoolArray() as $bool) {
            $this->assertTrue($bool);
        }
        foreach ($this->create(false, 'No', 'Off', 'False', 0)->asBoolArray() as $bool) {
            $this->assertFalse($bool);
        }

        $this->expectFTE();
        $this->create(3)->asBoolArray();
    }

    public function testObject()
    {
        foreach ($this->create((object)['today' => 'good day'])->asObjectArray() as $object) {
            $this->assertEquals('good day', $object->getString('today'));
        }

        $this->expectFTE();
        $this->create(3)->asObjectArray();
    }

    public function testArray()
    {
        foreach ($this->create([3, 3, 3, 3])->asArrayArray() as $array) {
            foreach ($array->asIntArray() as $int) {
                $this->assertEquals(3, $int);
            }
        }

        $this->expectFTE();
        $this->create(3)->asArrayArray();
    }

    public function testIteration()
    {
        foreach ($this->create(0, 1, 2, 3) as $k => $n) {
            $this->assertEquals($k, $n);
        }
    }
}