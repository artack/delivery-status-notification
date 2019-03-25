<?php

declare(strict_types=1);

namespace Artack\Dsn;

use Artack\Dsn\Field\ValueField;
use PHPUnit\Framework\TestCase;

class FieldsTest extends TestCase
{
    public function testFields(): void
    {
        $firstValueField = new ValueField('fiRst', 'value', null);
        $secondValueField = new ValueField('Second', 'value', null);
        $thirdValueField = new ValueField('ThirD', 'value', null);
        $fields = new Fields($firstValueField, $secondValueField, $thirdValueField);

        $this->assertCount(3, $fields->getAll());
        $this->assertSame($firstValueField, $fields->get('first'));
        $this->assertSame($firstValueField, $fields->get('FiRsT'));
        $this->assertNull($fields->get('non-existent'));

        $this->assertSame([
            'first',
            'second',
            'third',
        ], $fields->getNames());

        $fields->remove('second');
        $this->assertCount(2, $fields->getAll());

        $fields->remove('tHirD');
        $this->assertCount(1, $fields->getAll());
    }
}
