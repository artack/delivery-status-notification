<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use Artack\Dsn\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ActionFieldTest extends TestCase
{
    public function testAction(): void
    {
        $actionFirst = 'failed';
        $actionSecond = 'delivered';

        $actionField = new ActionField('name', $actionFirst);
        $this->assertSame($actionFirst, $actionField->getAction());

        $actionField->setAction($actionSecond);
        $this->assertEquals($actionSecond, $actionField->getAction());
    }

    /**
     * @dataProvider validActionProvider
     */
    public function testValidAction(string $action): void
    {
        $actionField = new ActionField('name', $action);
        $this->assertEquals($action, $actionField->getAction());
    }

    /**
     * @dataProvider invalidActionProvider
     */
    public function testInvalidAction(string $action): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ActionField('name', $action);
    }

    public function validActionProvider(): array
    {
        return [
            ['failed'],
            ['delayed'],
            ['delivered'],
            ['relayed'],
            ['expanded'],
        ];
    }

    public function invalidActionProvider(): array
    {
        return [
            ['something'],
            ['else'],
        ];
    }
}
