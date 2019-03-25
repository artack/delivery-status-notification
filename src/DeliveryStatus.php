<?php

declare(strict_types=1);

namespace Artack\Dsn;

class DeliveryStatus
{
    private $messageFields;
    private $recipientFields = [];

    public function getMessageFields(): Fields
    {
        return $this->messageFields;
    }

    public function setMessageFields(Fields $messageFields): void
    {
        $this->messageFields = $messageFields;
    }

    /**
     * @return Fields[]
     */
    public function getRecipientFields(): array
    {
        return $this->recipientFields;
    }

    public function addRecipientFields(Fields $recipientFields): void
    {
        $this->recipientFields[] = $recipientFields;
    }

    public function countRecipientFields(): int
    {
        return \count($this->recipientFields);
    }
}
