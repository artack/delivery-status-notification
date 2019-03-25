<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use PHPUnit\Framework\TestCase;

class AddressTypeFieldTest extends TestCase
{
    public function testType(): void
    {
        $typeFirst = 'rfc822';
        $typeSecond = 'x400';

        $addressTypeField = new AddressTypeField('name', 'value', $typeFirst, null);

        $this->assertSame($typeFirst, $addressTypeField->getType());

        $addressTypeField->setValue($typeSecond);

        $this->assertSame($typeSecond, $addressTypeField->getValue());
    }

    /**
     * @dataProvider validTypeProvider
     */
    public function testWithValidType(string $type): void
    {
        $addressTypeField = new AddressTypeField('name', 'value', $type, null);

        $this->assertSame($type, $addressTypeField->getType());
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testInvalidType(string $type): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AddressTypeField('name', 'value', $type, null);
    }

    public function validTypeProvider(): array
    {
        return [
            ['rfc822'],
            ['x400'],
            ['UTF-8'],
        ];
    }

    public function invalidTypeProvider(): array
    {
        return [
            ['something'],
            ['else'],
        ];
    }
}
