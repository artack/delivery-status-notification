<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use PHPUnit\Framework\TestCase;

class DateFieldTest extends TestCase
{
    public function testWithDateTime(): void
    {
        $timeZone = new \DateTimeZone('Europe/Zurich');

        $dateTimeFirst = (new \DateTime('2019-02-25 09:15:30'))->setTimezone($timeZone);
        $dateTimeSecond = (clone $dateTimeFirst)->modify('+2 hour');

        $dateField = new DateField('name', $dateTimeFirst);
        $this->assertEquals($dateTimeFirst, $dateField->getDateTime());

        $dateField->setDateTime($dateTimeSecond);
        $this->assertEquals($dateTimeSecond, $dateField->getDateTime());
    }

    public function testWithImmutableDateTime(): void
    {
        $timeZone = new \DateTimeZone('Europe/Zurich');

        $dateTimeFirst = (new \DateTimeImmutable('2019-02-25 09:15:30'))->setTimezone($timeZone);
        $dateTimeSecond = $dateTimeFirst->modify('+2 hour');

        $dateField = new DateField('name', $dateTimeFirst);
        $this->assertEquals($dateTimeFirst, $dateField->getDateTime());

        $dateField->setDateTime($dateTimeSecond);
        $this->assertEquals($dateTimeSecond, $dateField->getDateTime());
    }
}
