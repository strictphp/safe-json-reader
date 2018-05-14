<?php declare(strict_types=1);

namespace Strict\SafeJSONReader\Tests;

use Strict\SafeJSONReader\Exceptions\FieldNotFoundException;
use Strict\SafeJSONReader\Exceptions\UnexpectedFieldTypeException;
use Strict\SafeJSONReader\JSONObjectReader;


trait ZZZObjectReaderTrait
{
    /** @var JSONObjectReader */
    protected $r;

    public function setUp()
    {
        $arr = [
            'string' => 'string',

            'float'           => 3.34,
            'stringLikeFloat' => '3.34',

            'int'           => 334,
            'stringLikeInt' => '334',

            'true'         => true,
            'trulyString1' => 'Yes',
            'trulyString2' => 'On',
            'trulyString3' => 'True',
            'trulyInt'     => 1,

            'false'        => false,
            'falsyString1' => 'No',
            'falsyString2' => 'Off',
            'falsyString3' => 'False',
            'falsyInt'     => 0,

            'array' => [
                "this", "is", 4, "pen"
            ]
        ];
        $arr['object'] = $arr;

        $this->r = new JSONObjectReader(json_decode(json_encode($arr), false, 512, JSON_BIGINT_AS_STRING), 'testObject');
    }

    abstract protected function expectException(string $s);

    protected function expectUnexpectedFieldType()
    {
        $this->expectException(UnexpectedFieldTypeException::class);
    }

    protected function expectNotFound()
    {
        $this->expectException(FieldNotFoundException::class);
    }

    abstract public function testNull(): void;
    abstract public function testInt(): void;
    abstract public function testFloat(): void;
    abstract public function testString(): void;
    abstract public function testBool(): void;
    abstract public function testArray(): void;
    abstract public function testObject(): void;
    abstract public function testRequire(): void;
}