<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use PHPUnit\Framework\TestCase;

class ValueFieldTest extends TestCase
{
    public function testWithoutComment(): void
    {
        $valueField = new ValueField('name', 'value', null);

        $this->assertSame('name', $valueField->getName());
        $this->assertSame('value', $valueField->getValue());

        $valueField->setValue('new_value');

        $this->assertSame('new_value', $valueField->getValue());
    }

    public function testWithComment(): void
    {
        $valueField = new ValueField('name', 'value', 'comment');

        $this->assertSame('name', $valueField->getName());
        $this->assertSame('value', $valueField->getValue());
        $this->assertSame('comment', $valueField->getComment());
    }
}
