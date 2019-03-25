<?php

declare(strict_types=1);

namespace Artack\Dsn;

use Artack\Dsn\Exception\DsnException;
use PHPUnit\Framework\TestCase;

class DeliveryStatusNotificationTest extends TestCase
{
    public function testDeliveryStatusNotification(): void
    {
        $this->expectException(DsnException::class);
        $this->expectExceptionMessage('Could not parse delivery status');
        $this->expectExceptionCode(0);

        DeliveryStatusNotification::from('nonsense content');
    }
}
