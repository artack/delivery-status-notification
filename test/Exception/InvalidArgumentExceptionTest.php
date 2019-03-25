<?php

declare(strict_types=1);

namespace Artack\Dsn\Exception;

use PHPUnit\Framework\TestCase;

class InvalidArgumentExceptionTest extends TestCase
{
    public function testExceptionClass(): void
    {
        $previousException = new \RuntimeException();
        $exception = new InvalidArgumentException('message', 1, $previousException);

        $this->assertSame('message', $exception->getMessage());
        $this->assertSame(1, $exception->getCode());
        $this->assertSame($previousException, $exception->getPrevious());
        $this->assertInstanceOf(DsnException::class, $exception);
    }
}
