<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use PHPUnit\Framework\TestCase;

class MtaNameTypeFieldTest extends TestCase
{
    public function testType(): void
    {
        $typeFirst = 'dns';
        $typeSecond = 'x400';

        $mtaNameTypeField = new MtaNameTypeField('name', 'value', $typeFirst, null);

        $this->assertSame($typeFirst, $mtaNameTypeField->getType());

        $mtaNameTypeField->setValue($typeSecond);

        $this->assertSame($typeSecond, $mtaNameTypeField->getValue());
    }

    /**
     * @dataProvider validTypeProvider
     */
    public function testWithValidType(string $type): void
    {
        $mtaNameTypeField = new MtaNameTypeField('name', 'value', $type, null);

        $this->assertSame($type, $mtaNameTypeField->getType());
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testInvalidType(string $type): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new MtaNameTypeField('name', 'value', $type, null);
    }

    public function validTypeProvider(): array
    {
        return [
            ['dns'],
            ['x400'],
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
