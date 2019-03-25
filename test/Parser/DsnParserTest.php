<?php

declare(strict_types=1);

namespace Artack\Dsn\Parser;

use Artack\Dsn\Exception\InvalidArgumentException;
use Artack\Dsn\Field\ActionField;
use Artack\Dsn\Field\AddressTypeField;
use Artack\Dsn\Field\DateField;
use Artack\Dsn\Field\DiagnosticTypeField;
use Artack\Dsn\Field\MtaNameTypeField;
use Artack\Dsn\Field\StatusField;
use PHPUnit\Framework\TestCase;

class DsnParserTest extends TestCase
{
    public function testDsn001(): void
    {
        $deliveryStatus = (new DsnParser())->parse($this->loadDsn('dsn001.txt'));

        $this->assertCount(1, $deliveryStatus->getRecipientFields());
        $this->assertSame(1, $deliveryStatus->countRecipientFields());

        $messageFields = $deliveryStatus->getMessageFields();
        $this->assertCount(4, $messageFields->getAll());

        /** @var MtaNameTypeField $reportingMtaField */
        $reportingMtaField = $messageFields->get('Reporting-MTA');
        $this->assertInstanceOf(MtaNameTypeField::class, $reportingMtaField);
        $this->assertSame('dns', $reportingMtaField->getType());
        $this->assertSame('googlemail.com', $reportingMtaField->getValue());

        /** @var MtaNameTypeField $receivedFromMtaField */
        $receivedFromMtaField = $messageFields->get('Received-From-MTA');
        $this->assertInstanceOf(MtaNameTypeField::class, $receivedFromMtaField);
        $this->assertSame('dns', $receivedFromMtaField->getType());
        $this->assertSame('anyone@gmail.com', $receivedFromMtaField->getValue());

        /** @var DateField $arrivalDateField */
        $arrivalDateField = $messageFields->get('Arrival-Date');
        $arrivalDateTime = new \DateTimeImmutable('2019-03-24 12:52:25 PDT');
        $this->assertInstanceOf(DateField::class, $arrivalDateField);
        $this->assertEquals($arrivalDateTime, $arrivalDateField->getDateTime());

        $recipientFields = $deliveryStatus->getRecipientFields()[0];

        /** @var AddressTypeField $finalRecipientField */
        $finalRecipientField = $recipientFields->get('Final-Recipient');
        $this->assertInstanceOf(AddressTypeField::class, $finalRecipientField);
        $this->assertSame('rfc822', $finalRecipientField->getType());
        $this->assertSame('non-existent-recipient@bluewin.ch', $finalRecipientField->getValue());

        /** @var ActionField $actionField */
        $actionField = $recipientFields->get('Action');
        $this->assertInstanceOf(ActionField::class, $actionField);
        $this->assertSame('failed', $actionField->getAction());

        /** @var StatusField $statusField */
        $statusField = $recipientFields->get('Status');
        $this->assertInstanceOf(StatusField::class, $statusField);
        $this->assertSame(5, $statusField->getCodeClass());
        $this->assertSame(1, $statusField->getCodeSubject());
        $this->assertSame(1, $statusField->getCodeEnumerated());
        $this->assertSame('5.1.1', $statusField->getCode());

        /** @var MtaNameTypeField $remoteMtaField */
        $remoteMtaField = $recipientFields->get('Remote-MTA');
        $this->assertInstanceOf(MtaNameTypeField::class, $remoteMtaField);
        $this->assertSame('dns', $remoteMtaField->getType());
        $this->assertSame('mxbw.lb.bluewin.ch.', $remoteMtaField->getValue());
        $this->assertSame('195.186.227.50, the server for the domain bluewin.ch.', $remoteMtaField->getComment());

        /** @var DiagnosticTypeField $diagnosticCodeField */
        $diagnosticCodeField = $recipientFields->get('Diagnostic-Code');
        $this->assertInstanceOf(DiagnosticTypeField::class, $diagnosticCodeField);
        $this->assertSame('smtp', $diagnosticCodeField->getType());
        $this->assertSame('550 5.1.1 <non-existent-recipient@bluewin.ch> recipient rejected, address unknown', $diagnosticCodeField->getValue());

        /** @var DateField $lastAttemptDateField */
        $lastAttemptDateField = $recipientFields->get('Last-Attempt-Date');
        $lastAttemptDateTime = new \DateTimeImmutable('2019-03-24 12:52:26 PDT');
        $this->assertInstanceOf(DateField::class, $lastAttemptDateField);
        $this->assertEquals($lastAttemptDateTime, $lastAttemptDateField->getDateTime());
    }

    public function testDsn002(): void
    {
        $deliveryStatus = (new DsnParser())->parse($this->loadDsn('dsn002.txt'));

        $this->assertCount(1, $deliveryStatus->getMessageFields()->getAll());
        $this->assertCount(1, $deliveryStatus->getRecipientFields());
        $this->assertSame(1, $deliveryStatus->countRecipientFields());
        $this->assertCount(6, $deliveryStatus->getRecipientFields()[0]->getAll());
    }

    public function testDsn003(): void
    {
        $deliveryStatus = (new DsnParser())->parse($this->loadDsn('dsn003.txt'));

        $this->assertCount(1, $deliveryStatus->getMessageFields()->getAll());
        $this->assertCount(3, $deliveryStatus->getRecipientFields());
        $this->assertSame(3, $deliveryStatus->countRecipientFields());
        $this->assertCount(6, $deliveryStatus->getRecipientFields()[0]->getAll());
        $this->assertCount(4, $deliveryStatus->getRecipientFields()[1]->getAll());
        $this->assertCount(6, $deliveryStatus->getRecipientFields()[2]->getAll());
    }

    public function testDsn004(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $deliveryStatus = (new DsnParser())->parse($this->loadDsn('dsn004.txt'));

        $this->assertCount(1, $deliveryStatus->getMessageFields()->getAll());
    }

    public function testDsn005(): void
    {
        $deliveryStatus = (new DsnParser())->parse($this->loadDsn('dsn005.txt'));

        $this->assertCount(1, $deliveryStatus->getMessageFields()->getAll());
        $this->assertCount(1, $deliveryStatus->getRecipientFields());
        $this->assertSame(1, $deliveryStatus->countRecipientFields());
        $this->assertCount(3, $deliveryStatus->getRecipientFields()[0]->getAll());
    }

    private function loadDsn(string $filename): string
    {
        $filepath = __DIR__.'/../Resources/dsn/'.$filename;
        $file = new \SplFileInfo($filepath);

        if (!$file->isReadable()) {
            throw new \RuntimeException(sprintf('cant read file "%s"', $filepath));
        }

        return file_get_contents($file->getPathname());
    }
}
