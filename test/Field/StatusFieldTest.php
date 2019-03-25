<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use PHPUnit\Framework\TestCase;

class StatusFieldTest extends TestCase
{
    public function testWithoutComment(): void
    {
        $codeClassFirst = 2;
        $codeSubjectFirst = 5;
        $codeEnumeratedFirst = 10;

        $codeClassSecond = 5;
        $codeSubjectSecond = 6;
        $codeEnumeratedSecond = 11;

        $statusField = new StatusField('name', $codeClassFirst, $codeSubjectFirst, $codeEnumeratedFirst, null);

        $this->assertSame($codeClassFirst, $statusField->getCodeClass());
        $this->assertSame($codeSubjectFirst, $statusField->getCodeSubject());
        $this->assertSame($codeEnumeratedFirst, $statusField->getCodeEnumerated());
        $this->assertSame($codeClassFirst.'.'.$codeSubjectFirst.'.'.$codeEnumeratedFirst, $statusField->getCode());

        $statusField->setCodeClass($codeClassSecond);
        $statusField->setCodeSubject($codeSubjectSecond);
        $statusField->setCodeEnumerated($codeEnumeratedSecond);

        $this->assertSame($codeClassSecond, $statusField->getCodeClass());
        $this->assertSame($codeSubjectSecond, $statusField->getCodeSubject());
        $this->assertSame($codeEnumeratedSecond, $statusField->getCodeEnumerated());
        $this->assertSame($codeClassSecond.'.'.$codeSubjectSecond.'.'.$codeEnumeratedSecond, $statusField->getCode());
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testWithInvalidInput(int $codeClass, int $codeSubject, int $codeEnumerated): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new StatusField('name', $codeClass, $codeSubject, $codeEnumerated, null);
    }

    public function invalidInputProvider()
    {
        return [
            [-1, 0, 0],
            [0, 0, 0],
            [1, 0, 0],
            [3, 0, 0],
            [6, 0, 0],
            [7, 0, 0],
            [2, -1, 0],
            [2, 8, 0],
            [2, 0, -1],
            [2, 0, 1000],
        ];
    }
}
