<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use Artack\Dsn\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DiagnosticTypeFieldTest extends TestCase
{
    public function testType(): void
    {
        $type = 'smtp';

        $diagnosticTypeField = new DiagnosticTypeField('name', 'value', $type, null);

        $this->assertSame($type, $diagnosticTypeField->getType());
    }

    /**
     * @dataProvider validTypeProvider
     */
    public function testWithValidType(string $type): void
    {
        $diagnosticTypeField = new DiagnosticTypeField('name', 'value', $type, null);

        $this->assertSame($type, $diagnosticTypeField->getType());
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testInvalidType(string $type): void
    {
        $this->expectException(InvalidArgumentException::class);

        new DiagnosticTypeField('name', 'value', $type, null);
    }

    public function validTypeProvider(): array
    {
        return [
            ['smtp'],
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
